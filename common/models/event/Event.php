<?php

namespace common\models\event;

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
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
        return RgTable::NAME_EVENT;
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
     * @return ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(
            EventType::class,
            [
                RgAttribute::ID => RgAttribute::TYPE_ID
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
                RgAttribute::ID => RgAttribute::INTEREST_CATEGORY_ID
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
                RgAttribute::ID => RgAttribute::USER_ID
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
                RgAttribute::EVENT_ID => RgAttribute::ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            RgAttribute::ID                     => Yii::t('app', 'ID'),
            RgAttribute::USER_ID                => Yii::t('app', 'User ID'),
            RgAttribute::TYPE_ID                => Yii::t('app', 'Type ID'),
            RgAttribute::STATUS_ID              => Yii::t('app', 'Status ID'),
            RgAttribute::NAME                   => Yii::t('app', 'Name'),
            RgAttribute::ABOUT                  => Yii::t('app', 'About'),
            RgAttribute::INTEREST_CATEGORY_ID   => Yii::t('app', 'Interest Category ID'),
            RgAttribute::CITY_ID                => Yii::t('app', 'City ID'),
            RgAttribute::ADDRESS                => Yii::t('app', 'Address'),
            RgAttribute::AGE_LIMIT              => Yii::t('app', 'Age Limit'),
            RgAttribute::TICKET_PRICE           => Yii::t('app', 'Ticket Price'),
            RgAttribute::TICKETS_NUMBER         => Yii::t('app', 'Tickets Number'),
            RgAttribute::ADDITIONAL_INFORMATION => Yii::t('app', 'Additional Information'),
            RgAttribute::IS_FREE                => Yii::t('app', 'Is Free'),
            RgAttribute::WALLPAPER              => Yii::t('app', 'Wallpaper'),
            RgAttribute::CREATED_AT             => Yii::t('app', 'Created At'),
            RgAttribute::UPDATED_AT             => Yii::t('app', 'Updated At'),
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
                    RgAttribute::TYPE_ID,
                    RgAttribute::NAME,
                    RgAttribute::ABOUT,
                    RgAttribute::INTEREST_CATEGORY_ID,
                    RgAttribute::CITY_ID,
                    RgAttribute::ADDRESS,
                    RgAttribute::AGE_LIMIT,
                    RgAttribute::WALLPAPER,
                    RgAttribute::STATUS_ID
                ],
                'required'
            ],
            [
                [
                    RgAttribute::USER_ID,
                    RgAttribute::TYPE_ID,
                    RgAttribute::INTEREST_CATEGORY_ID,
                    RgAttribute::CITY_ID,
                    RgAttribute::AGE_LIMIT,
                    RgAttribute::TICKETS_NUMBER,
                    RgAttribute::STATUS_ID
                ],
                'integer'
            ],
            [
                [RgAttribute::TICKET_PRICE],
                'number'
            ],
            [
                [RgAttribute::IS_FREE],
                'boolean'
            ],
            [
                [
                    RgAttribute::CREATED_AT,
                    RgAttribute::UPDATED_AT
                ],
                'safe'
            ],
            [
                [RgAttribute::NAME],
                'string',
                'max' => 20
            ],
            [
                [RgAttribute::ABOUT],
                'string',
                'max' => 60
            ],
            [
                [
                    RgAttribute::ADDRESS,
                    RgAttribute::WALLPAPER
                ],
                'string',
                'max' => 255
            ],
            [
                [RgAttribute::ADDITIONAL_INFORMATION],
                'string',
                'max' => 200
            ],
            [
                [RgAttribute::CITY_ID],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => City::class,
                'targetAttribute' => [
                    RgAttribute::CITY_ID => RgAttribute::ID
                ]
            ],
            [
                [RgAttribute::TYPE_ID],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => EventType::class,
                'targetAttribute' => [
                    RgAttribute::TYPE_ID => RgAttribute::ID
                ]
            ],
            [
                [RgAttribute::INTEREST_CATEGORY_ID],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => InterestCategory::class,
                'targetAttribute' => [
                    RgAttribute::INTEREST_CATEGORY_ID => RgAttribute::ID
                ]
            ],
            [
                [RgAttribute::USER_ID],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::class,
                'targetAttribute' => [
                    RgAttribute::USER_ID => RgAttribute::ID
                ]
            ],
        ];
    }
}
