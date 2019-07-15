<?php

namespace common\models\user;

use common\models\system\BaseModel;
use common\models\User;
use Exception;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Модель таблицы "user_profile".
 *
 * @property int    $id                  Идентификатор профиля пользователя
 * @property int    $user_id             Идентификатор пользователя
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
 * @property string $created_at          Дата создания
 * @property string $updated_at          Дата последнего обновления
 */
class UserProfile extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'city'], 'required'],
            [['user_id'], 'default', 'value' => null],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['category_profile_id', 'name', 'surname', 'patronymic', 'lang', 'short_lang', 'about', 'country', 'city', 'longitude', 'latitude'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                  => 'ID',
            'user_id'             => 'User ID',
            'category_profile_id' => 'Category Profile ID',
            'name'                => 'Name',
            'surname'             => 'Surname',
            'patronymic'          => 'Patronymic',
            'lang'                => 'Lang',
            'short_lang'          => 'Short Lang',
            'about'               => 'About',
            'country'             => 'Country',
            'city'                => 'City',
            'longitude'           => 'Longitude',
            'latitude'            => 'Latitude',
            'created_at'          => 'Created At',
            'updated_at'          => 'Updated At',
        ];
    }

    /**
     * Создание нового профиля для пользователя
     *
     * @param array $data
     * @return UserProfile
     * @throws Exception
     */
    public static final function create(array $data): self
    {
        $newUserProfile = new self($data);

        if (!$newUserProfile->validate() || !$newUserProfile->save()) {
            throw new InvalidArgumentException('Ошибка при создании профиля пользователя');
        }

        return $newUserProfile;
    }
}
