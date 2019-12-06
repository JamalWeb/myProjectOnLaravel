<?php

namespace common\models\event;

use common\models\base\BaseModel;
use common\models\City;
use common\models\InterestCategory;
use common\models\user\User;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "event".
 *
 * @property int                 $id                     Идентификатор события
 * @property int                 $user_id                Идентификатор пользователя который создал событие
 * @property int                 $type_id                Тип события
 * @property string              $name                   Наименование
 * @property string              $about                  Описание
 * @property int                 $interest_category_id   Идентификатор категории интереса
 * @property int                 $city_id                Идентификатор города
 * @property string              $address                Адрес где будет происходить
 * @property int                 $age_limit              Возростное ограничение
 * @property string              $ticket_price           Цена за один билет
 * @property int                 $number_tickets         Доступные билеты
 * @property string              $additional_information Дополнительная информация
 * @property bool                $is_free                Флаг бесплатно или нет (если да то цена не учитывается)
 * @property string              $wallpaper              Фоновое изображение
 * @property string              $created_at             Дата создания
 * @property string              $updated_at             Дата обновления
 * @property City                $city
 * @property EventType           $type
 * @property InterestCategory    $interestCategory
 * @property User                $user
 * @property EventPhotoGallery[] $eventPhotoGalleries
 */
class Event extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type_id', 'name', 'about', 'interest_category_id', 'city_id', 'address', 'age_limit', 'wallpaper'], 'required'],
            [['user_id', 'type_id', 'interest_category_id', 'city_id', 'age_limit', 'number_tickets'], 'default', 'value' => null],
            [['user_id', 'type_id', 'interest_category_id', 'city_id', 'age_limit', 'number_tickets'], 'integer'],
            [['ticket_price'], 'number'],
            [['is_free'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 20],
            [['about'], 'string', 'max' => 60],
            [['address', 'wallpaper'], 'string', 'max' => 255],
            [['additional_information'], 'string', 'max' => 200],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventType::class, 'targetAttribute' => ['type_id' => 'id']],
            [['interest_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => InterestCategory::class, 'targetAttribute' => ['interest_category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                     => Yii::t('app', 'ID'),
            'user_id'                => Yii::t('app', 'User ID'),
            'type_id'                => Yii::t('app', 'Type ID'),
            'name'                   => Yii::t('app', 'Name'),
            'about'                  => Yii::t('app', 'About'),
            'interest_category_id'   => Yii::t('app', 'Interest Category ID'),
            'city_id'                => Yii::t('app', 'City ID'),
            'address'                => Yii::t('app', 'Address'),
            'age_limit'              => Yii::t('app', 'Age Limit'),
            'ticket_price'           => Yii::t('app', 'Ticket Price'),
            'number_tickets'         => Yii::t('app', 'Number Tickets'),
            'additional_information' => Yii::t('app', 'Additional Information'),
            'is_free'                => Yii::t('app', 'Is Free'),
            'wallpaper'              => Yii::t('app', 'Wallpaper'),
            'created_at'             => Yii::t('app', 'Created At'),
            'updated_at'             => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(EventType::class, ['id' => 'type_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getInterestCategory()
    {
        return $this->hasOne(InterestCategory::class, ['id' => 'interest_category_id']);
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
    public function getEventPhotoGalleries()
    {
        return $this->hasMany(EventPhotoGallery::class, ['event_id' => 'id']);
    }
}
