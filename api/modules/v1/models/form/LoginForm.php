<?php

namespace api\modules\v1\models\form;

use amnah\yii2\user\models\UserToken;
use amnah\yii2\user\Module;
use api\modules\v1\models\error\ValidationException;
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
    /**
     * @var Module
     */
    public $module;

    /**
     * @var User $user
     */
    private $user;

    /**
     * @var string $email
     */
    public $email;

    /**
     * @var string $password
     */
    public $password;

    public function init(): void
    {
        if (is_null($this->module)) {
            $this->module = Yii::$app->getModule('user');
        }
    }

    /**
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
     * @throws ValidationException
     */
    public function validateUser(): void
    {
        /** @var User $user */
        $user = $this->getUser();

        if (is_null($user)) {
            throw new ValidationException(['email' => Yii::t('user', 'Email not found')]);
        }

        if (!$user->validatePassword($this->password)) {
            throw new ValidationException(['password' => Yii::t('user', 'Incorrect password')]);
        }

        if ($user->is_banned) {
            throw new ValidationException([
                'email' => Yii::t('user', 'User is banned - {banReason}', [
                    'banReason' => $user->banned_reason,
                ])
            ]);
        }

        if ($user->status !== $user::STATUS_UNCONFIRMED_EMAIL) {
            /** @var UserToken $userToken */
            $userToken = $this->module->model('UserToken');
            $userToken = $userToken::generate($user->id, $userToken::TYPE_EMAIL_ACTIVATE);
            $user->sendEmailConfirmation($userToken);
            throw new ValidationException(["email" => Yii::t("user", "Confirmation email resent")]);
        }
    }

    /**
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

    public function attributeLabels(): array
    {
        return [
            'email'    => 'Email',
            'password' => 'Password'
        ];
    }
}
