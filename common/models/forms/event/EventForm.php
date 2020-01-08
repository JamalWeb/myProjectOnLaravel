<?php

namespace common\models\forms\event;

use api\modules\v1\models\error\BadRequestHttpException;
use common\components\ArrayHelper;
use common\components\helpers\FileHelper;
use common\components\registry\RgAttribute;
use common\models\City;
use common\models\event\Event;
use common\models\event\EventCarryingDate;
use common\models\event\EventPhotoGallery;
use common\models\event\EventStatus;
use common\models\InterestCategory;
use common\models\user\User;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * @var int            $user_id
 * @var int            $type_id
 * @var string         $name
 * @var string         $about
 * @var int            $interest_category_id
 * @var int            $city_id
 * @var string         $address
 * @var int            $min_age_child
 * @var int            $max_age_child
 * @var float          $ticket_price
 * @var int            $tickets_number
 * @var string         $additional_information
 * @var string         $carrying_date
 * @var UploadedFile   $wallpaper
 * @var UploadedFile[] $photo_gallery
 * @var string         $pathSetImages
 */
class EventForm extends Model
{
    public $user_id;
    public $type_id;
    public $name;
    public $about;
    public $interest_category_id;
    public $city_id;
    public $address;
    public $min_age_child;
    public $max_age_child;
    public $ticket_price;
    public $tickets_number;
    public $additional_information;
    public $carrying_date;
    public $wallpaper;
    public $photo_gallery;
    private $pathSetImage;

    public function init()
    {
        parent::init();
        $this->pathSetImage = Yii::getAlias('@setEventImg');
    }

    /**
     * @return Event
     * @throws BadRequestHttpException
     * @throws Exception
     * @throws \yii\web\BadRequestHttpException
     * @throws \Exception
     */
    public function createEvent(): Event
    {
        $attribute = [
            RgAttribute::USER_ID                => $this->user_id,
            RgAttribute::TYPE_ID                => $this->type_id,
            RgAttribute::STATUS_ID              => EventStatus::MODERATION,
            RgAttribute::NAME                   => $this->name,
            RgAttribute::ABOUT                  => $this->about,
            RgAttribute::INTEREST_CATEGORY_ID   => $this->interest_category_id,
            RgAttribute::CITY_ID                => $this->city_id,
            RgAttribute::ADDRESS                => $this->address,
            RgAttribute::MIN_AGE_CHILD          => $this->min_age_child,
            RgAttribute::MAX_AGE_CHILD          => $this->max_age_child,
            RgAttribute::TICKET_PRICE           => $this->ticket_price,
            RgAttribute::TICKETS_NUMBER         => $this->tickets_number,
            RgAttribute::ADDITIONAL_INFORMATION => $this->additional_information,
        ];
        $event = new Event($attribute);
        $event->saveModel();
        $this->saveWallpaper($event);
        $this->savePhotoGallery($event);
        $this->setCarryingDate($event);

        return $event;
    }

    /**
     * Сохранить фоновый рисунок
     *
     * @param Event $event
     * @throws Exception
     * @throws \yii\web\BadRequestHttpException
     */
    private function saveWallpaper(Event $event): void
    {
        $path = "{$this->pathSetImage}/{$this->user_id}/{$event->id}/wallpaper";
        $fileName = FileHelper::saveFile($path, $this->wallpaper);
        $eventAttribute = [
            RgAttribute::WALLPAPER => $fileName
        ];
        $event->updateAttributes($eventAttribute);
    }

    /**
     * Сохранить фото-галерею
     *
     * @param Event $event
     * @throws BadRequestHttpException
     * @throws Exception
     * @throws \yii\web\BadRequestHttpException
     */
    private function savePhotoGallery(Event $event): void
    {
        $path = "{$this->pathSetImage}/{$this->user_id}/{$event->id}/photo_gallery";
        $photoNames = FileHelper::saveFiles($path, $this->photo_gallery);
        foreach (ArrayHelper::generator($photoNames) as $photoName) {
            $eventPhotoGallery = new EventPhotoGallery();
            $eventPhotoGallery->name = $photoName;
            $eventPhotoGallery->event_id = $event->id;
            $eventPhotoGallery->saveModel();
        }
    }

    /**
     * Установить даты проведения
     *
     * @param Event $event
     * @throws \Exception
     */
    private function setCarryingDate(Event $event): void
    {
        $carryingDates = ArrayHelper::jsonToArray($this->carrying_date);
        foreach (ArrayHelper::generator($carryingDates) as $carryingDate) {
            $eventCarryingDate = new EventCarryingDate();
            $eventCarryingDate->event_id = $event->id;
            $eventCarryingDate->date = $carryingDate[RgAttribute::DATE];
            $eventCarryingDate->duration = $carryingDate[RgAttribute::DURATION];
            $eventCarryingDate->saveModel();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            RgAttribute::USER_ID                => Yii::t('app', 'User ID'),
            RgAttribute::TYPE_ID                => Yii::t('app', 'Type ID'),
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
            RgAttribute::CARRYING_DATE          => Yii::t('app', 'Carrying Date'),
            RgAttribute::PHOTO_GALLERY          => Yii::t('app', 'Photo Gallery'),
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
                    RgAttribute::WALLPAPER,
                    RgAttribute::CARRYING_DATE,
                ],
                'required'
            ],
            [
                [
                    RgAttribute::USER_ID,
                    RgAttribute::TYPE_ID,
                    RgAttribute::INTEREST_CATEGORY_ID,
                    RgAttribute::CITY_ID,
                ],
                'integer'
            ],
            [
                [
                    RgAttribute::MIN_AGE_CHILD,
                    RgAttribute::MAX_AGE_CHILD
                ],
                'integer',
                'min' => 0,
                'max' => 21
            ],
            [
                [
                    RgAttribute::TICKETS_NUMBER
                ],
                'integer',
                'min' => 0
            ],
            [
                [
                    RgAttribute::TICKET_PRICE
                ],
                'number',
                'min' => 0
            ],
            [
                [
                    RgAttribute::NAME,
                    RgAttribute::ABOUT,
                    RgAttribute::ADDITIONAL_INFORMATION
                ],
                'filter',
                'filter' => function ($str) {
                    return preg_replace('/\s+/', ' ', $str);
                }
            ],
            [
                RgAttribute::NAME,
                'match',
                'pattern' => '/^[а-яёa-z0-9][а-яёa-z0-9 _.&]*$/ui'
            ],
            [
                [
                    RgAttribute::NAME
                ],
                'string',
                'length' => [3, 60]
            ],
            [
                [
                    RgAttribute::ABOUT
                ],
                'string',
                'length' => [10, 100]
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
                    RgAttribute::ADDRESS,
                    RgAttribute::CARRYING_DATE
                ],
                'string'
            ],
            [
                [
                    RgAttribute::WALLPAPER
                ],
                'image',
                'skipOnEmpty' => true,
                'extensions'  => 'png, jpg, jpeg',
                'maxWidth'    => 1024,
                'maxHeight'   => 768,
                'maxSize'     => 5120 * 1024
            ],
            [
                [
                    RgAttribute::PHOTO_GALLERY
                ],
                'image',
                'skipOnEmpty' => true,
                'extensions'  => 'png, jpg, jpeg',
                'maxWidth'    => 1024,
                'maxHeight'   => 768,
                'maxSize'     => 5120 * 1024,
                'maxFiles'    => 10
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
            ]
        ];
    }
}
