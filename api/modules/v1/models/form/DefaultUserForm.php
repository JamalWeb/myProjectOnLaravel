<?php

namespace api\modules\v1\models\form;

use common\models\user\User;
use Yii;
use yii\base\Model;

/**
 * Class UserForm
 *
 * @property string  $email      Email
 * @property string  $password   Пароль
 * @property string  $first_name Имя
 * @property string  $last_name  Фамилия
 * @property integer $city_id    Идентификатор города
 * @property integer $country_id Идентификатор страны
 * @property float   $longitude  Координаты: Широта
 * @property float   $latitude   Координаты: Долгота
 * @property string  $language   Язык
 * @property string  $short_lang Код языка
 * @property string  $timezone   Часовой пояс
 * @property string  $children   Список детей
 */
class DefaultUserForm extends Model
{
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $country_id;
    public $city_id;
    public $longitude;
    public $latitude;
    public $language;
    public $short_lang;
    public $timezone;
    public $children;

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
            [
                ['email'], function ($attribute) {
                $user = User::find()->where(['email' => $this->email])->exists();
                if ($user) {
                    $this->addError($attribute, 'This email is already in use.');
                }
            }
            ],
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
