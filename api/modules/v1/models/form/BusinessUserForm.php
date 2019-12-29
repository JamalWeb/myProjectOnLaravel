<?php

namespace api\modules\v1\models\form;

use common\components\registry\AttrRegistry;
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
            [
                [
                    AttrRegistry::CITY_ID,
                    AttrRegistry::FIRST_NAME,
                    AttrRegistry::EMAIL,
                    AttrRegistry::PASSWORD,
                    AttrRegistry::PHONE_NUMBER,
                    AttrRegistry::ABOUT
                ],
                'required'
            ],
            [
                [
                    AttrRegistry::CITY_ID,
                    AttrRegistry::COUNTRY_ID
                ],
                'integer'
            ],
            [
                [
                    AttrRegistry::FIRST_NAME,
                    AttrRegistry::EMAIL,
                    AttrRegistry::PASSWORD,
                    AttrRegistry::PHONE_NUMBER,
                    AttrRegistry::ABOUT,
                    AttrRegistry::ADDRESS,
                    AttrRegistry::LANGUAGE,
                    AttrRegistry::SHORT_LANG,
                    AttrRegistry::TIMEZONE
                ],
                'string'
            ],
            [
                [
                    AttrRegistry::EMAIL
                ],
                'email'
            ],
            [
                [AttrRegistry::EMAIL],
                function ($attribute) {
                    $user = User::find()
                        ->where(
                            [
                                AttrRegistry::EMAIL => $this->email
                            ]
                        )
                        ->exists();
                    if ($user) {
                        $this->addError($attribute, 'This email is already in use.');
                    }
                }
            ],
            [
                [AttrRegistry::PASSWORD],
                'string',
                'min' => 6,
                'max' => 20
            ],
            [
                [
                    AttrRegistry::LONGITUDE,
                    AttrRegistry::LATITUDE
                ],
                'number'
            ]
        ];
    }
}
