<?php

namespace common\models\event;

use common\components\ArrayHelper;
use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use common\models\base\BaseModel;
use common\models\City;
use common\models\InterestCategory;
use common\models\user\User;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\web\BadRequestHttpException;
use yii\web\UrlManager;

/**
 * @property int                 $id                         Идентификатор события
 * @property int                 $user_id                    Идентификатор пользователя который создал событие
 * @property int                 $type_id                    Тип события
 * @property int                 $status_id                  Статус события
 * @property string              $name                       Наименование
 * @property string              $about                      Описание
 * @property int                 $interest_category_id       Идентификатор категории интереса
 * @property int                 $city_id                    Идентификатор города
 * @property string              $address                    Адрес где будет происходить
 * @property int                 $min_age_child              Минимальный допустимый возраст ребенка
 * @property int                 $max_age_child              Максимальный допустимый возраст ребенка
 * @property string              $ticket_price               Цена за один билет
 * @property int                 $tickets_number             Кол-во доступных билетов
 * @property string              $additional_information     Дополнительная информация
 * @property string              $wallpaper                  Фоновое изображение
 * @property string              $created_at                 Дата создания
 * @property string              $updated_at                 Дата обновления
 * @property City                $city
 * @property EventType           $type
 * @property InterestCategory    $interestCategory
 * @property User                $user
 * @property EventPhotoGallery[] $eventPhotoGallery
 * @property EventCarryingDate[] $eventCarryingDates
 * @property array               $publicInfo
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
     * @return array
     * @throws BadRequestHttpException
     * @throws InvalidConfigException
     */
    public function getPublicInfo(): array
    {
        return [
            RgAttribute::ID                     => $this->id,
            RgAttribute::NAME                   => $this->name,
            RgAttribute::ABOUT                  => $this->about,
            RgAttribute::ADDRESS                => $this->address,
            RgAttribute::TICKET_PRICE           => (float)$this->ticket_price,
            RgAttribute::TICKETS_NUMBER         => $this->tickets_number,
            RgAttribute::ADDITIONAL_INFORMATION => $this->additional_information,
            RgAttribute::WALLPAPER              => $this->getWallpaperUrl(),
            RgAttribute::USER                   => $this->user->publicInfo,
            RgAttribute::AGE_CHILD              => [
                RgAttribute::MIN => $this->min_age_child,
                RgAttribute::MAX => $this->max_age_child,
            ],
            RgAttribute::TYPE                   => [
                RgAttribute::ID   => $this->type_id,
                RgAttribute::NAME => EventType::getName($this->type_id)
            ],
            RgAttribute::STATUS                 => [
                RgAttribute::ID   => $this->status_id,
                RgAttribute::NAME => EventStatus::getName($this->status_id)
            ],
            RgAttribute::INTEREST_CATEGORY      => [
                RgAttribute::ID   => $this->interestCategory->id,
                RgAttribute::NAME => $this->interestCategory->name,
            ],
            RgAttribute::CITY                   => [
                RgAttribute::ID   => $this->city->id,
                RgAttribute::NAME => $this->city->name
            ],
            RgAttribute::CARRYING_DATE          => $this->getCarryingDates(),
            RgAttribute::PHOTO_GALLERY          => $this->getPhotoGallery()
        ];
    }

    private function getCarryingDates(): array
    {
        $carryingDates = [];
        if (!empty($this->eventCarryingDates)) {
            /** @var EventCarryingDate $eventCarryingDate */
            foreach (ArrayHelper::generator($this->eventCarryingDates) as $eventCarryingDate) {
                $carryingDates[] = $eventCarryingDate->publicInfo;
            }
        }

        return $carryingDates;
    }

    /**
     * @throws InvalidConfigException
     */
    private function getWallpaperUrl(): string
    {
        /** @var UrlManager $urlManagerFront */
        $urlManagerFront = Yii::$app->get('urlManagerFront');
        $basePathEventImg = Yii::getAlias('@getEventImg');

        $wallpaperUrl = "{$urlManagerFront->baseUrl}/";
        $wallpaperUrl .= "{$basePathEventImg}/";
        $wallpaperUrl .= "{$this->user_id}/";
        $wallpaperUrl .= "{$this->id}/";
        $wallpaperUrl .= "wallpaper/";
        $wallpaperUrl .= "{$this->wallpaper}";

        return $wallpaperUrl;
    }

    /**
     * @return array
     * @throws InvalidConfigException
     */
    private function getPhotoGallery()
    {
        /** @var UrlManager $urlManagerFront */
        $urlManagerFront = Yii::$app->get('urlManagerFront');
        $basePathEventImg = Yii::getAlias('@getEventImg');

        $photoUrl = "{$urlManagerFront->baseUrl}/";
        $photoUrl .= "{$basePathEventImg}/";
        $photoUrl .= "{$this->user_id}/";
        $photoUrl .= "{$this->id}/";
        $photoUrl .= "photo_gallery/";

        $photoGallery = [];
        if (!empty($this->eventPhotoGallery)) {
            /** @var EventPhotoGallery $eventPhotoGallery */
            foreach (ArrayHelper::generator($this->eventPhotoGallery) as $eventPhotoGallery) {
                $photoGallery[] = [
                    RgAttribute::ID  => $eventPhotoGallery->id,
                    RgAttribute::URL => "{$photoUrl}{$eventPhotoGallery->name}"
                ];
            }
        }

        return $photoGallery;
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
    public function getEventPhotoGallery()
    {
        return $this->hasMany(
            EventPhotoGallery::class,
            [
                RgAttribute::EVENT_ID => RgAttribute::ID
            ]
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getEventCarryingDates()
    {
        return $this->hasMany(
            EventCarryingDate::class,
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
            RgAttribute::MIN_AGE_CHILD          => Yii::t('app', 'Min Age Child'),
            RgAttribute::MAX_AGE_CHILD          => Yii::t('app', 'Max Age Child'),
            RgAttribute::TICKET_PRICE           => Yii::t('app', 'Ticket Price'),
            RgAttribute::TICKETS_NUMBER         => Yii::t('app', 'Tickets Number'),
            RgAttribute::ADDITIONAL_INFORMATION => Yii::t('app', 'Additional Information'),
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
                    RgAttribute::MIN_AGE_CHILD,
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
                    RgAttribute::MIN_AGE_CHILD,
                    RgAttribute::MAX_AGE_CHILD,
                    RgAttribute::TICKETS_NUMBER,
                    RgAttribute::STATUS_ID
                ],
                'integer'
            ],
            [
                [
                    RgAttribute::TICKET_PRICE
                ],
                'number'
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
                    RgAttribute::NAME
                ],
                'string',
                'max' => 20
            ],
            [
                [
                    RgAttribute::ABOUT
                ],
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
                [
                    RgAttribute::ADDITIONAL_INFORMATION
                ],
                'string',
                'max' => 200
            ],
            [
                [
                    RgAttribute::CITY_ID
                ],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => City::class,
                'targetAttribute' => [
                    RgAttribute::CITY_ID => RgAttribute::ID
                ]
            ],
            [
                [
                    RgAttribute::INTEREST_CATEGORY_ID
                ],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => InterestCategory::class,
                'targetAttribute' => [
                    RgAttribute::INTEREST_CATEGORY_ID => RgAttribute::ID
                ]
            ],
            [
                [
                    RgAttribute::USER_ID
                ],
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
