<?php

namespace backend\models\Site;

use backend\Entity\Services\User\Dto\UserLoginDto;
use common\models\user\User;
use yii\base\Model;

/**
 *
 * @property UserLoginDto $dto
 */
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
            ],
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
            'login'      => 'Вход',
            'password'   => 'Пароль',
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

    protected function getUser()
    {
        if ($this->user === null) {
            $this->user = User::findOne(['email' => $this->login]);
        }

        return $this->user;
    }

    public function getDto(): UserLoginDto
    {
        $dto = new UserLoginDto();
        $dto->user = $this->user;
        $dto->rememberMe = $this->rememberMe;

        return $dto;
    }
}
