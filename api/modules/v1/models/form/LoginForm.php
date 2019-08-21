<?php

namespace api\modules\v1\models\form;

use amnah\yii2\user\Module;
use api\modules\v1\models\error\UnauthorizedHttpException;
use common\models\user\User;
use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 *
 * @package api\modules\v1\models\form
 */
class LoginForm extends Model
{
    /** @var Module */
    private $module;

    /** @var string $keyAttempt */
    private $keyAttempt;

    /** @var User $user */
    private $user;

    /** @var string $email */
    public $email;

    /** @var string $password */
    public $password;

    /** Инициализация формы */
    public function init(): void
    {
        if (is_null($this->module)) {
            $this->module = Yii::$app->getModule('user');
        }
    }

    /**
     * Правила для валидации атрибутов
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            [['email', 'password'], 'string'],
            [['email'], 'email'],
            ['email', 'validateUser']
        ];
    }

    /**
     * Наименование атрибутов формы
     *
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'email'    => 'Email',
            'password' => 'Password'
        ];
    }

    /**
     * @throws UnauthorizedHttpException
     */
    public function validateUser(): void
    {
        /** @var User $user */
        $user = $this->getUser();

        $this->writeAttemptKey();
        $attempt = Yii::$app->cache->get($this->keyAttempt);
        if ($attempt >= 2) {
            throw new UnauthorizedHttpException([
                'email' => 'Вы превысили лимит попыток авторизации'
            ]);
        }

        if (is_null($user)) {
            $this->handleFailure();
            throw new UnauthorizedHttpException([
                'email' => Yii::t('user', 'Email not found')
            ]);
        }

        if (!$user->validatePassword($this->password)) {
            $this->handleFailure();
            throw new UnauthorizedHttpException([
                'password' => Yii::t('user', 'Incorrect password')
            ]);
        }

        if ($user->is_banned) {
            throw new UnauthorizedHttpException([
                'email' => Yii::t('user', 'User is banned - {banReason}', [
                    'banReason' => $user->banned_reason,
                ])
            ]);
        }

        $this->validateStatus();

        $this->authenticate();
    }

    /**
     * Валидация статуса пользователя
     *
     * @throws UnauthorizedHttpException
     */
    private function validateStatus(): void
    {
        switch ($this->user->status) {
            case User::STATUS_INACTIVE:
                $error = ['email' => 'Ваш аккаунт не активирован'];
                break;
            case User::STATUS_UNCONFIRMED_EMAIL:
                $error = ['email' => 'Пожалуйста подтвердите Вашу почту'];
                break;
        }

        if (isset($error)) {
            throw new UnauthorizedHttpException($error);
        }
    }

    /**
     * Получить пользователя
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        if (is_null($this->user)) {
            $user = $this->module->model('User');

            $this->user = $user::find()
                ->where(['email' => $this->email])
                ->one();
        }

        return $this->user;
    }

    private function writeAttemptKey(): void
    {
        $this->keyAttempt = 'auth_' . md5($this->email);
    }

    private function handleFailure(): void
    {
        $attempt = Yii::$app->cache->get($this->keyAttempt) ? 1 : 0;
        Yii::$app->cache->set($this->keyAttempt, ($attempt + 1), 600);
    }

    private function authenticate(): void
    {
        //        /**
//         * Язык системы
//         */
//        Yii::$app->language = 'ru';
//        if (isset($user['language'])) {
//            Yii::$app->language = mb_strtolower($params['language']);
//        }

        $identity = $this->getUser();

        $user = Yii::$app->user;
        $user->switchIdentity($identity);
        $user->login($identity);
        $user->setIdentity($identity);

        Yii::$app->cache->delete($this->keyAttempt);
    }
}
