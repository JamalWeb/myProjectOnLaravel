<?php

namespace common\models\event;

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
use common\models\base\BaseModel;
use common\models\City;
use common\models\InterestCategory;
use common\models\user\User;
use Yii;
use yii\db\ActiveQuery;

/**
 * @property int                 $id                     Идентификатор события
 * @property int                 $user_id                Идентификатор пользователя который создал событие
 * @property int                 $type_id                Тип события
 * @property int                 $status_id              Статус события
 * @property string              $name                   Наименование
 * @property string              $about                  Описание
 * @property int                 $interest_category_id   Идентификатор категории интереса
 * @property int                 $city_id                Идентификатор города
 * @property string              $address                Адрес где будет происходить
 * @property int                 $age_limit              Возростное ограничение
 * @property string              $ticket_price           Цена за один билет
 * @property int                 $tickets_number         Кол-во доступных билетов
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
        return TableRegistry::NAME_EVENT;
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
     * @return ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(
            EventType::class,
            [
                AttrRegistry::ID => AttrRegistry::TYPE_ID
            ]
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getInterestCategory()
    {
        return $this->hasOne(
            InterestCategory::class,
            [
                AttrRegistry::ID => AttrRegistry::INTEREST_CATEGORY_ID
            ]
        );
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
    public function getEventPhotoGalleries()
    {
        return $this->hasMany(
            EventPhotoGallery::class,
            [
                AttrRegistry::EVENT_ID => AttrRegistry::ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            AttrRegistry::ID                     => Yii::t('app', 'ID'),
            AttrRegistry::USER_ID                => Yii::t('app', 'User ID'),
            AttrRegistry::TYPE_ID                => Yii::t('app', 'Type ID'),
            AttrRegistry::STATUS_ID              => Yii::t('app', 'Status ID'),
            AttrRegistry::NAME                   => Yii::t('app', 'Name'),
            AttrRegistry::ABOUT                  => Yii::t('app', 'About'),
            AttrRegistry::INTEREST_CATEGORY_ID   => Yii::t('app', 'Interest Category ID'),
            AttrRegistry::CITY_ID                => Yii::t('app', 'City ID'),
            AttrRegistry::ADDRESS                => Yii::t('app', 'Address'),
            AttrRegistry::AGE_LIMIT              => Yii::t('app', 'Age Limit'),
            AttrRegistry::TICKET_PRICE           => Yii::t('app', 'Ticket Price'),
            AttrRegistry::TICKETS_NUMBER         => Yii::t('app', 'Tickets Number'),
            AttrRegistry::ADDITIONAL_INFORMATION => Yii::t('app', 'Additional Information'),
            AttrRegistry::IS_FREE                => Yii::t('app', 'Is Free'),
            AttrRegistry::WALLPAPER              => Yii::t('app', 'Wallpaper'),
            AttrRegistry::CREATED_AT             => Yii::t('app', 'Created At'),
            AttrRegistry::UPDATED_AT             => Yii::t('app', 'Updated At'),
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
                    AttrRegistry::TYPE_ID,
                    AttrRegistry::NAME,
                    AttrRegistry::ABOUT,
                    AttrRegistry::INTEREST_CATEGORY_ID,
                    AttrRegistry::CITY_ID,
                    AttrRegistry::ADDRESS,
                    AttrRegistry::AGE_LIMIT,
                    AttrRegistry::WALLPAPER,
                    AttrRegistry::STATUS_ID
                ],
                'required'
            ],
            [
                [
                    AttrRegistry::USER_ID,
                    AttrRegistry::TYPE_ID,
                    AttrRegistry::INTEREST_CATEGORY_ID,
                    AttrRegistry::CITY_ID,
                    AttrRegistry::AGE_LIMIT,
                    AttrRegistry::TICKETS_NUMBER,
                    AttrRegistry::STATUS_ID
                ],
                'integer'
            ],
            [
                [AttrRegistry::TICKET_PRICE],
                'number'
            ],
            [
                [AttrRegistry::IS_FREE],
                'boolean'
            ],
            [
                [
                    AttrRegistry::CREATED_AT,
                    AttrRegistry::UPDATED_AT
                ],
                'safe'
            ],
            [
                [AttrRegistry::NAME],
                'string',
                'max' => 20
            ],
            [
                [AttrRegistry::ABOUT],
                'string',
                'max' => 60
            ],
            [
                [
                    AttrRegistry::ADDRESS,
                    AttrRegistry::WALLPAPER
                ],
                'string',
                'max' => 255
            ],
            [
                [AttrRegistry::ADDITIONAL_INFORMATION],
                'string',
                'max' => 200
            ],
            [
                [AttrRegistry::CITY_ID],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => City::class,
                'targetAttribute' => [
                    AttrRegistry::CITY_ID => AttrRegistry::ID
                ]
            ],
            [
                [AttrRegistry::TYPE_ID],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => EventType::class,
                'targetAttribute' => [
                    AttrRegistry::TYPE_ID => AttrRegistry::ID
                ]
            ],
            [
                [AttrRegistry::INTEREST_CATEGORY_ID],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => InterestCategory::class,
                'targetAttribute' => [
                    AttrRegistry::INTEREST_CATEGORY_ID => AttrRegistry::ID
                ]
            ],
            [
                [AttrRegistry::USER_ID],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::class,
                'targetAttribute' => [
                    AttrRegistry::USER_ID => AttrRegistry::ID
                ]
            ],
        ];
    }
}
