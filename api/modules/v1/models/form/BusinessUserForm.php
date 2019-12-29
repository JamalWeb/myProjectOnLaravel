<?php

namespace api\modules\v1\models\form;

use common\components\registry\RgAttribute;
use common\models\user\User;
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
            [
                [
                    RgAttribute::CITY_ID,
                    RgAttribute::FIRST_NAME,
                    RgAttribute::EMAIL,
                    RgAttribute::PASSWORD,
                    RgAttribute::PHONE_NUMBER,
                    RgAttribute::ABOUT
                ],
                'required'
            ],
            [
                [
                    RgAttribute::CITY_ID,
                    RgAttribute::COUNTRY_ID
                ],
                'integer'
            ],
            [
                [
                    RgAttribute::FIRST_NAME,
                    RgAttribute::EMAIL,
                    RgAttribute::PASSWORD,
                    RgAttribute::PHONE_NUMBER,
                    RgAttribute::ABOUT,
                    RgAttribute::ADDRESS,
                    RgAttribute::LANGUAGE,
                    RgAttribute::SHORT_LANG,
                    RgAttribute::TIMEZONE
                ],
                'string'
            ],
            [
                [
                    RgAttribute::EMAIL
                ],
                'email'
            ],
            [
                [RgAttribute::EMAIL],
                function ($attribute) {
                    $user = User::find()
                        ->where(
                            [
                                RgAttribute::EMAIL => $this->email
                            ]
                        )
                        ->exists();
                    if ($user) {
                        $this->addError($attribute, 'This email is already in use.');
                    }
                }
            ],
            [
                [RgAttribute::PASSWORD],
                'string',
                'min' => 6,
                'max' => 20
            ],
            [
                [
                    RgAttribute::LONGITUDE,
                    RgAttribute::LATITUDE
                ],
                'number'
            ]
        ];
    }
}
