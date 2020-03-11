<?php

namespace common\models\user;

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use common\models\base\BaseModel;
use common\models\City;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "user_profile".
 *
 * @property int    $id           Идентификатор профиля
 * @property int    $user_id      Идентификатор пользователя
 * @property string $first_name   Имя
 * @property string $last_name    Фамилия
 * @property string $patronymic   Отчество
 * @property string $avatar       Аватар
 * @property string $phone_number Телефоный номер
 * @property string $address      Адрес
 * @property int    $gender_id    Идентификатор пола
 * @property string $about        Описание бизнес аккаунта
 * @property int    $country_id   Идентификатор страны
 * @property int    $city_id      Идентификатор города
 * @property bool   $is_closed    Профиль закрыт
 * @property bool   $is_notice    Получать уведомления
 * @property string $longitude    Координаты: долгота
 * @property string $latitude     Координаты: широта
 * @property string $language     Язык
 * @property string $short_lang   Код языка
 * @property string $timezone     Часовой пояс
 * @property string $created_at   Дата создания
 * @property string $updated_at   Дата обновления
 * @property User   $user         Пользователь
 * @property City   $city         Город
 */
class UserProfile extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return RgTable::NAME_USER_PROFILE;
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(
            User::class,
            [
                RgAttribute::ID => RgAttribute::USER_ID
            ]
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(
            City::class,
            [
                RgAttribute::ID => RgAttribute::CITY_ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            RgAttribute::ID           => Yii::t('app', 'ID'),
            RgAttribute::USER_ID      => Yii::t('app', 'User ID'),
            RgAttribute::FIRST_NAME   => Yii::t('app', 'First Name'),
            RgAttribute::LAST_NAME    => Yii::t('app', 'Last Name'),
            RgAttribute::PATRONYMIC   => Yii::t('app', 'Patronymic'),
            RgAttribute::AVATAR       => Yii::t('app', 'Avatar'),
            RgAttribute::PHONE_NUMBER => Yii::t('app', 'Phone Number'),
            RgAttribute::ADDRESS      => Yii::t('app', 'Address'),
            RgAttribute::GENDER_ID    => Yii::t('app', 'Gender ID'),
            RgAttribute::ABOUT        => Yii::t('app', 'About'),
            RgAttribute::COUNTRY_ID   => Yii::t('app', 'Country ID'),
            RgAttribute::CITY_ID      => Yii::t('app', 'City ID'),
            RgAttribute::IS_CLOSED    => Yii::t('app', 'Is Closed'),
            RgAttribute::IS_NOTICE    => Yii::t('app', 'Is Notice'),
            RgAttribute::LONGITUDE    => Yii::t('app', 'Longitude'),
            RgAttribute::LATITUDE     => Yii::t('app', 'Latitude'),
            RgAttribute::LANGUAGE     => Yii::t('app', 'Language'),
            RgAttribute::SHORT_LANG   => Yii::t('app', 'Short Lang'),
            RgAttribute::TIMEZONE     => Yii::t('app', 'Timezone'),
            RgAttribute::CREATED_AT   => Yii::t('app', 'Created At'),
            RgAttribute::UPDATED_AT   => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    RgAttribute::USER_ID,
                    RgAttribute::CITY_ID
                ],
                'required'
            ],
            [
                [
                    RgAttribute::USER_ID,
                    RgAttribute::GENDER_ID,
                    RgAttribute::COUNTRY_ID,
                    RgAttribute::CITY_ID
                ],
                'default',
                'value' => null
            ],
            [
                [
                    RgAttribute::USER_ID,
                    RgAttribute::GENDER_ID,
                    RgAttribute::COUNTRY_ID,
                    RgAttribute::CITY_ID
                ],
                'integer'
            ],
            [
                [
                    RgAttribute::CREATED_AT,
                    RgAttribute::UPDATED_AT
                ],
                'safe'
            ],
            [
                [
                    RgAttribute::FIRST_NAME,
                    RgAttribute::LAST_NAME,
                    RgAttribute::PATRONYMIC,
                    RgAttribute::AVATAR,
                    RgAttribute::PHONE_NUMBER,
                    RgAttribute::ADDRESS,
                    RgAttribute::ABOUT,
                    RgAttribute::LONGITUDE,
                    RgAttribute::LATITUDE,
                    RgAttribute::LANGUAGE,
                    RgAttribute::SHORT_LANG,
                    RgAttribute::TIMEZONE
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    RgAttribute::IS_CLOSED,
                    RgAttribute::IS_NOTICE
                ],
                'boolean'
            ]
        ];
    }
}
