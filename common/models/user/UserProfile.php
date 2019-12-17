<?php

namespace common\models\user;

use common\components\registry\Constants;
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
        return Constants::TABLE_NAME_USER_PROFILE;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'city_id'], 'required'],
            [['user_id', 'gender_id', 'country_id', 'city_id'], 'default', 'value' => null],
            [['user_id', 'gender_id', 'country_id', 'city_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [
                [
                    'first_name',
                    'last_name',
                    'patronymic',
                    'avatar',
                    'phone_number',
                    'address',
                    'about',
                    'longitude',
                    'latitude',
                    'language',
                    'short_lang',
                    'timezone'
                ], 'string', 'max' => 255
            ],
            [['is_closed', 'is_notice'], 'boolean']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => Yii::t('app', 'ID'),
            'user_id'      => Yii::t('app', 'User ID'),
            'first_name'   => Yii::t('app', 'First Name'),
            'last_name'    => Yii::t('app', 'Last Name'),
            'patronymic'   => Yii::t('app', 'Patronymic'),
            'avatar'       => Yii::t('app', 'Avatar'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'address'      => Yii::t('app', 'Address'),
            'gender_id'    => Yii::t('app', 'Gender ID'),
            'about'        => Yii::t('app', 'About'),
            'country_id'   => Yii::t('app', 'Country ID'),
            'city_id'      => Yii::t('app', 'City ID'),
            'is_closed'    => Yii::t('app', 'Is Closed'),
            'is_notice'    => Yii::t('app', 'Is Notice'),
            'longitude'    => Yii::t('app', 'Longitude'),
            'latitude'     => Yii::t('app', 'Latitude'),
            'language'     => Yii::t('app', 'Language'),
            'short_lang'   => Yii::t('app', 'Short Lang'),
            'timezone'     => Yii::t('app', 'Timezone'),
            'created_at'   => Yii::t('app', 'Created At'),
            'updated_at'   => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }
}
