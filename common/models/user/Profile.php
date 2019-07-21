<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int    $id
 * @property int    $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $full_name
 * @property string $timezone
 * @property string $category_profile_id Идентификатор категории пррофиля
 * @property string $name                Имя
 * @property string $surname             Фамилия
 * @property string $patronymic          Отчество
 * @property string $lang                Язык
 * @property string $short_lang          Код языка
 * @property string $about               Описание бизнес аккаунта
 * @property string $country             Страна
 * @property string $city                Город
 * @property string $longitude           Координаты: долгота
 * @property string $latitude            Координаты: широта
 * @property User   $user
 */
class Profile extends \amnah\yii2\user\models\Profile
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'default', 'value' => null],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['full_name', 'timezone', 'category_profile_id', 'name', 'surname', 'patronymic', 'lang', 'short_lang', 'about', 'country', 'city', 'longitude', 'latitude'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                  => Yii::t('api', 'ID'),
            'user_id'             => Yii::t('api', 'User ID'),
            'created_at'          => Yii::t('api', 'Created At'),
            'updated_at'          => Yii::t('api', 'Updated At'),
            'full_name'           => Yii::t('api', 'Full Name'),
            'timezone'            => Yii::t('api', 'Timezone'),
            'category_profile_id' => Yii::t('api', 'Category Profile ID'),
            'name'                => Yii::t('api', 'Name'),
            'surname'             => Yii::t('api', 'Surname'),
            'patronymic'          => Yii::t('api', 'Patronymic'),
            'lang'                => Yii::t('api', 'Lang'),
            'short_lang'          => Yii::t('api', 'Short Lang'),
            'about'               => Yii::t('api', 'About'),
            'country'             => Yii::t('api', 'Country'),
            'city'                => Yii::t('api', 'City'),
            'longitude'           => Yii::t('api', 'Longitude'),
            'latitude'            => Yii::t('api', 'Latitude'),
        ];
    }
}
