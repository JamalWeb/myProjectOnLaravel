<?php

namespace api\modules\v1\classes;

use api\filters\event\EventFilter;
use api\modules\v1\classes\base\Api;
use api\modules\v1\models\error\BadRequestHttpException;
use common\components\ArrayHelper;
use common\components\helpers\DataProviderHelper;
use common\components\registry\RgAttribute;
use common\models\event\Event;
use common\models\event\EventStatus;
use common\models\event\EventType;
use common\models\forms\event\EventForm;
use common\models\user\User;
use Exception;
use Yii;
use yii\web\UploadedFile;

class EventApi extends Api
{
    /**
     * Получить список типов
     *
     * @return array
     */
    public function getTypeList(): array
    {
        return EventType::getList();
    }

    /**
     * Получить список статусов
     *
     * @return array
     */
    public function getStatusList(): array
    {
        return EventStatus::getList();
    }

    /**
     * @param User  $user
     * @param array $post
     * @return array
     * @throws Exception
     */
    public function create(User $user, array $post)
    {
        $allowedAttribute = [
            RgAttribute::TYPE_ID,
            RgAttribute::NAME,
            RgAttribute::ABOUT,
            RgAttribute::INTEREST_CATEGORY_ID,
            RgAttribute::CITY_ID,
            RgAttribute::ADDRESS,
            RgAttribute::MIN_AGE_CHILD,
            RgAttribute::MAX_AGE_CHILD,
            RgAttribute::TICKET_PRICE,
            RgAttribute::TICKETS_NUMBER,
            RgAttribute::ADDITIONAL_INFORMATION,
            RgAttribute::CARRYING_DATE,
        ];
        ArrayHelper::cleaning($post, $allowedAttribute);

        $eventForm = new EventForm($post);
        $eventForm->setAttributes(
            [
                RgAttribute::USER_ID       => $user->id,
                RgAttribute::WALLPAPER     => UploadedFile::getInstanceByName(RgAttribute::WALLPAPER),
                RgAttribute::PHOTO_GALLERY => UploadedFile::getInstancesByName(RgAttribute::PHOTO_GALLERY)
            ]
        );

        if (!$eventForm->validate()) {
            throw new BadRequestHttpException($eventForm->getFirstErrors());
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $event = $eventForm->createEvent();
            $transaction->commit();

            return $event->publicInfo;
        } catch (Exception $ex) {
            $transaction->rollBack();
            throw $ex;
        }
    }

    /**
     * Получить событие по его идентификатору
     *
     * @param array $get
     * @return array
     * @throws BadRequestHttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function get(array $get): array
    {
        ArrayHelper::validateParams($get, [RgAttribute::ID]);

        return self::findEventById($get[RgAttribute::ID])->publicInfo;
    }

    /**
     * Поиск события по идентификатору
     *
     * @param int $id
     * @return Event
     * @throws \yii\web\BadRequestHttpException
     */
    public static function findEventById(int $id): Event
    {
        $event = Event::findOne([RgAttribute::ID => $id]);

        if ($event === null) {
            throw new \yii\web\BadRequestHttpException('Event not found');
        }

        return $event;
    }

    /**
     * @param User  $user
     * @param array $get
     * @return array
     * @throws \yii\web\BadRequestHttpException
     */
    public function getListByUser(User $user, array $get): array
    {
        $userId = $get[RgAttribute::USER_ID] ?? null;

        if ($userId !== null) {
            $user = UserApi::findUserById($userId);
        }

        $eventList = Event::find()
            ->where(
                [
                    RgAttribute::USER_ID => $user->id
                ]
            );

        return DataProviderHelper::active($eventList, $get);
    }

    public function list(array $get)
    {
        $filter = new EventFilter();
        $filter->setAttributes($get);

        return $filter;
    }
}
