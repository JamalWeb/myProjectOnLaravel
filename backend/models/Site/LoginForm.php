<?php

namespace backend\models\Site;

use common\models\user\User;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    /** @var string */
    public $login;

    /** @var string */
    public $password;

    /** @var bool */
    public $rememberMe = true;

    /** @var User */
    private $user;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [

            [
                [
                    'login',
                    'password',
                ],
                'required',
            ],
            [
                'rememberMe',
                'boolean',
            ]
            ,

            [
                'password',
                'validatePassword',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): ?array
    {
        return [
            'login' => 'Вход',
            'password' => 'Пароль',
            'rememberMe' => 'Запомни меня',
        ];
    }


    public function validatePassword($attribute): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }


    public function sigIn(): bool
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    protected function getUser()
    {
        if ($this->user === null) {
            $this->user = User::findByUserName($this->login);
        }

        return $this->user;
    }
}
