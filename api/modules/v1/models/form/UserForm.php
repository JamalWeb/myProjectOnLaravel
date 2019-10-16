<?php

namespace api\modules\v1\models\form;

use Yii;
use yii\base\Model;

/**
 * Class UserForm
 *
 * @property string  $first_name    Имя
 * @property string  $last_name     Фамилия
 * @property string  $email         Email
 * @property string  $password      Пароль
 * @property integer $city_id       Идентификатор города
 * @property integer $country_id    Идентификатор страны
 * @property string  $children      Список детей
 * @property float   $longitude     Координаты: Широта
 * @property float   $latitude      Координаты: Долгота
 * @property string  $language      Язык
 * @property string  $short_lang    Код языка
 * @property string  $timezone      Часовой пояс
 */
class UserForm extends Model
{
    public $country_id;
    public $city_id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $children;
    public $longitude;
    public $latitude;
    public $language;
    public $short_lang;
    public $timezone;

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'first_name', 'email', 'password'], 'required'],
            [['city_id', 'country_id'], 'integer'],
            [['first_name', 'last_name', 'email', 'password', 'children', 'language', 'short_lang', 'timezone'], 'string'],
            [['email'], 'email'],
            [['password'], 'string', 'min' => 6, 'max' => 20],
            [['longitude', 'latitude'], 'number']
        ];
    }

    public function attributeLabels()
    {
        return [
            'country_id' => Yii::t('api', 'country_id'),
            'city_id'    => Yii::t('api', 'city_id'),
            'first_name' => Yii::t('api', 'first_name'),
            'last_name'  => Yii::t('api', 'last_name'),
            'email'      => Yii::t('api', 'email'),
            'password'   => Yii::t('api', 'password'),
            'children'   => Yii::t('api', 'children'),
            'longitude'  => Yii::t('api', 'longitude'),
            'latitude'   => Yii::t('api', 'latitude'),
            'language'   => Yii::t('api', 'language'),
            'short_lang' => Yii::t('api', 'short_lang'),
            'timezone'   => Yii::t('api', 'timezone'),
        ];
    }
}
