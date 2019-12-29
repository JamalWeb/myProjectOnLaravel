<?php

namespace common\models\user;

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
use common\models\City;
use Yii;
use common\models\base\BaseModel;
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
        return TableRegistry::NAME_USER_PROFILE;
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(
            User::class,
            [
                AttrRegistry::ID => AttrRegistry::USER_ID
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
                AttrRegistry::ID => AttrRegistry::CITY_ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            AttrRegistry::ID           => Yii::t('app', 'ID'),
            AttrRegistry::USER_ID      => Yii::t('app', 'User ID'),
            AttrRegistry::FIRST_NAME   => Yii::t('app', 'First Name'),
            AttrRegistry::LAST_NAME    => Yii::t('app', 'Last Name'),
            AttrRegistry::PATRONYMIC   => Yii::t('app', 'Patronymic'),
            AttrRegistry::AVATAR       => Yii::t('app', 'Avatar'),
            AttrRegistry::PHONE_NUMBER => Yii::t('app', 'Phone Number'),
            AttrRegistry::ADDRESS      => Yii::t('app', 'Address'),
            AttrRegistry::GENDER_ID    => Yii::t('app', 'Gender ID'),
            AttrRegistry::ABOUT        => Yii::t('app', 'About'),
            AttrRegistry::COUNTRY_ID   => Yii::t('app', 'Country ID'),
            AttrRegistry::CITY_ID      => Yii::t('app', 'City ID'),
            AttrRegistry::IS_CLOSED    => Yii::t('app', 'Is Closed'),
            AttrRegistry::IS_NOTICE    => Yii::t('app', 'Is Notice'),
            AttrRegistry::LONGITUDE    => Yii::t('app', 'Longitude'),
            AttrRegistry::LATITUDE     => Yii::t('app', 'Latitude'),
            AttrRegistry::LANGUAGE     => Yii::t('app', 'Language'),
            AttrRegistry::SHORT_LANG   => Yii::t('app', 'Short Lang'),
            AttrRegistry::TIMEZONE     => Yii::t('app', 'Timezone'),
            AttrRegistry::CREATED_AT   => Yii::t('app', 'Created At'),
            AttrRegistry::UPDATED_AT   => Yii::t('app', 'Updated At'),
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
                    AttrRegistry::USER_ID,
                    AttrRegistry::CITY_ID
                ],
                'required'
            ],
            [
                [
                    AttrRegistry::USER_ID,
                    AttrRegistry::GENDER_ID,
                    AttrRegistry::COUNTRY_ID,
                    AttrRegistry::CITY_ID
                ],
                'default',
                'value' => null
            ],
            [
                [
                    AttrRegistry::USER_ID,
                    AttrRegistry::GENDER_ID,
                    AttrRegistry::COUNTRY_ID,
                    AttrRegistry::CITY_ID
                ],
                'integer'
            ],
            [
                [
                    AttrRegistry::CREATED_AT,
                    AttrRegistry::UPDATED_AT
                ],
                'safe'
            ],
            [
                [
                    AttrRegistry::FIRST_NAME,
                    AttrRegistry::LAST_NAME,
                    AttrRegistry::PATRONYMIC,
                    AttrRegistry::AVATAR,
                    AttrRegistry::PHONE_NUMBER,
                    AttrRegistry::ADDRESS,
                    AttrRegistry::ABOUT,
                    AttrRegistry::LONGITUDE,
                    AttrRegistry::LATITUDE,
                    AttrRegistry::LANGUAGE,
                    AttrRegistry::SHORT_LANG,
                    AttrRegistry::TIMEZONE
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    AttrRegistry::IS_CLOSED,
                    AttrRegistry::IS_NOTICE
                ],
                'boolean'
            ]
        ];
    }
}
