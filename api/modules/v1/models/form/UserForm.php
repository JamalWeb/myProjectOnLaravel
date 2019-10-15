<?php

namespace api\modules\v1\models\form;

use Yii;
use yii\base\Model;

/**
 * Class UserForm
 *
 * @property string  $first_name Имя
 * @property string  $last_name  Фамилия
 * @property string  $email      Email
 * @property string  $password   Пароль
 * @property integer $city_id    Идентификатор города
 * @property string  $children   Список детей
 */
class UserForm extends Model
{
    public $city_id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $children;

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'first_name', 'email', 'password'], 'required'],
            [['city_id'], 'integer'],
            [['first_name', 'last_name', 'email', 'password', 'children'], 'string'],
            [['email'], 'email'],
            [['password'], 'string', 'min' => 6, 'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'city_id'    => Yii::t('api', 'city_id'),
            'first_name' => Yii::t('api', 'first_name'),
            'last_name'  => Yii::t('api', 'last_name'),
            'email'      => Yii::t('api', 'email'),
            'password'   => Yii::t('api', 'password'),
            'children'   => Yii::t('api', 'children'),
        ];
    }
}
