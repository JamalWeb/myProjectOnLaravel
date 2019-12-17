<?php

namespace api\modules\v1\models\form;

use common\components\registry\TableRegistry;
use common\components\registry\UserRegistry;
use Yii;
use api\modules\v1\models\error\UnauthorizedHttpException;
use common\models\user\User;
use yii\base\Model;

/**
 * Class LoginForm
 *
 * @package api\modules\v1\models\form
 */
class LoginForm extends Model
{
    /** @var int */
    const COUNT_ATTEMPT = 10;

    /** @var int */
    const TIME_UNAUTHORIZED_DURATION = 600;

    /** @var string $keyAttempts */
    private $keyAttempts;

    /** @var User $user */
    private $user;

    /** @var string $email */
    public $email;

    /** @var string $password */
    public $password;

    /**
     * @return bool
     * @throws UnauthorizedHttpException
     */
    public function beforeValidate(): bool
    {
        $parent = parent::beforeValidate();

        if (!is_null($this->email)) {
            $this->createKeyAttempts();

            $countAttempt = Yii::$app->cache->get($this->keyAttempts);
            if ($countAttempt >= self::COUNT_ATTEMPT) {
                throw new UnauthorizedHttpException([
                    'attempt_error' => 'Вы превысили лимит попыток авторизации'
                ]);
            }
        }

        return $parent;
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            [['email', 'password'], 'string'],
            [['email'], 'email'],
        ];
    }

    /**
     * @throws UnauthorizedHttpException
     */
    public function afterValidate(): void
    {
        parent::afterValidate();

        $this->getUser();

        if (is_null($this->user)) {
            $this->handleFailure();
            throw new UnauthorizedHttpException([
                'email' => Yii::t('app', 'Email not found')
            ]);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function attributeLabels(): array
    {
        return [
            'email'    => 'Email',
            'password' => 'Password'
        ];
    }

    /**
     * Получить пользователя
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        if (is_null($this->user)) {

            $this->user = User::find()
                ->where(['email' => $this->email])
                ->one();
        }

        return $this->user;
    }

    /**
     * Авторизация
     *
     * @return User
     * @throws UnauthorizedHttpException
     */
    public final function authenticate(): User
    {
        if (!$this->validate()) {
            throw new UnauthorizedHttpException($this->getFirstErrors());
        }

        if (!$this->user->validatePassword($this->password)) {
            $this->handleFailure();
            throw new UnauthorizedHttpException([
                'password' => Yii::t('app', 'Incorrect password')
            ]);
        }

        if ($this->user->is_banned) {
            throw new UnauthorizedHttpException([
                'email' => Yii::t('app', 'User is banned - {banReason}', [
                    'banReason' => $this->user->banned_reason,
                ])
            ]);
        }

        switch ($this->user->status) {
            case UserRegistry::USER_STATUS_INACTIVE:
                $error = ['email' => 'Ваш аккаунт отключен'];
                break;
//            case User::STATUS_UNCONFIRMED_EMAIL:
//                $error = ['email' => 'Пожалуйста подтвердите Вашу почту'];
//                break;
        }

        if (isset($error)) {
            throw new UnauthorizedHttpException($error);
        }

//        Язык системы
//        Yii::$app->language = 'ru';
//        if (isset($user['language'])) {
//            Yii::$app->language = mb_strtolower($params['language']);
//        }

        $user = Yii::$app->user;
        $user->switchIdentity($this->user);
        $user->login($this->user);
        $user->setIdentity($this->user);

        Yii::$app->cache->delete($this->keyAttempts);

        return $this->user;
    }

    private function createKeyAttempts(): void
    {
        $this->keyAttempts = 'auth_' . md5($this->email);
    }

    private function handleFailure(): void
    {
        $attempt = Yii::$app->cache->get($this->keyAttempts) ? 1 : 0;
        Yii::$app->cache->set($this->keyAttempts, ($attempt + 1), self::TIME_UNAUTHORIZED_DURATION);
    }
}
