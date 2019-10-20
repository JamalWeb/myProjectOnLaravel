<?php

namespace api\modules\v1\models\form;

use common\models\user\User;
use Yii;
use yii\base\Model;

/**
 * Class BusinessUserForm
 *
 * @property string  $email        Email
 * @property string  $password     Пароль
 * @property string  $first_name   Название
 * @property string  $phone_number Телефонный номер
 * @property string  $address      Адрес
 * @property string  $about        Описание
 * @property integer $country_id   Идентификатор страны
 * @property integer $city_id      Идентификатор города
 * @property float   $longitude    Координаты: Широта
 * @property float   $latitude     Координаты: Долгота
 * @property string  $language     Язык
 * @property string  $short_lang   Код языка
 * @property string  $timezone     Часовой пояс
 */
class BusinessUserForm extends Model
{
    public $email;
    public $password;
    public $first_name;
    public $phone_number;
    public $address;
    public $about;
    public $country_id;
    public $city_id;
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
            [['city_id', 'first_name', 'email', 'password', 'phone_number', 'about'], 'required'],
            [['city_id', 'country_id'], 'integer'],
            [['first_name', 'email', 'password', 'phone_number', 'about', 'address', 'language', 'short_lang', 'timezone'], 'string'],
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

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'country_id'   => Yii::t('api', 'Country ID'),
            'city_id'      => Yii::t('api', 'City ID'),
            'first_name'   => Yii::t('api', 'First Name'),
            'email'        => Yii::t('api', 'Email'),
            'password'     => Yii::t('api', 'Password'),
            'address'      => Yii::t('api', 'Address'),
            'phone_number' => Yii::t('api', 'Phone Number'),
            'about'        => Yii::t('api', 'About'),
            'longitude'    => Yii::t('api', 'Longitude'),
            'latitude'     => Yii::t('api', 'Latitude'),
            'language'     => Yii::t('api', 'Language'),
            'short_lang'   => Yii::t('api', 'Short Lang'),
            'timezone'     => Yii::t('api', 'Timezone'),
        ];
    }
}
