<?php


namespace backend\models\Cabinet;


use yii\base\Model;

class UserForm extends Model
{
    public $username;
    public $email;
    public $createdAt;
    public $updatedAt;
    public $role;
    public $type;

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'username'  => 'Имя пользователя',
            'email'     => 'Email',
            'createdAt' => 'Дата регистраций',
            'role'      => 'Роль',
            'type'      => 'Тип',
        ];
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type ? 'System' : 'Системный';
    }


}