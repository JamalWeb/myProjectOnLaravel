<?php


namespace backend\models\Cabinet;


use common\components\StringHelper;
use yii\base\Model;

class ProfileForm extends Model
{
    public $firstName;
    public $lastName;
    public $patronymic;
    public $avatar;
    public $phoneNumber;
    public $address;
    public $gender;

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'firstName'   => 'Имя',
            'lastName'    => 'Фамилия',
            'patronymic'  => 'Отчество',
            'phoneNumber' => 'Номер телефона',
            'address'     => 'Адрес',
            'gender'      => 'Пол',
        ];
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return StringHelper::getFirstLetter($this->gender);
    }

}