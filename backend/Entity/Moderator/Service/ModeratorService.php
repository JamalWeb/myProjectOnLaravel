<?php

namespace backend\Entity\Moderator\Service;

use backend\Entity\Services\User\Repository\UserRepository;
use common\components\EmailSender;
use common\models\event\Event;
use common\models\user\User;
use yii\web\NotFoundHttpException;

class ModeratorService
{

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * ModeratorService constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $field
     * @param $value
     * @throws NotFoundHttpException
     */
    public function validateExists(string $field, $value): void
    {
        $user = User::find()->where([$field => $value])->exists();

        if (!$user) {
            throw new NotFoundHttpException("Пользователь с {$field}: {$value} не найден");
        }
    }

    /**
     * @param string $field
     * @param $value
     * @return User|null
     * @throws NotFoundHttpException
     */
    public function findOneUser(string $field, $value): ?User
    {
        $this->validateExists($field, $value);

        return User::findOne([$field => $value]);
    }


    /**
     * @param string $field
     * @param $value
     * @return Event
     * @throws NotFoundHttpException
     */
    public function findOneEvent(string $field, $value): Event
    {
        $event = Event::findOne([$field => $value]);

        if ($event === null) {
            throw new NotFoundHttpException('Событие не найдено');
        }

        return $event;
    }

    /**
     * @param int $id
     * @param int $newStatusId
     * @return bool
     * @throws NotFoundHttpException
     */
    public function changeStatusUser(int $id, int $newStatusId): bool
    {
        $user = $this->findOneUser('id', $id);
        $user->status_id = $newStatusId;
        $saveResult = $user->save();
        $sendResult = EmailSender::changeStatusBusinessProfile($user);

        return $saveResult && $sendResult;
    }

    /**
     * @param int $id
     * @param int $newStatusId
     * @return bool
     * @throws NotFoundHttpException
     */
    public function changeStatusEvent(int $id, int $newStatusId): bool
    {
        $event = $this->findOneEvent('id', $id);
        $event->status_id = $newStatusId;
        $saveResult = $event->save();
        $sendResult = EmailSender::changeStatusEvent($event);

        return $saveResult && $sendResult;
    }

    /**
     * Фильтр для GridView
     * @param string $q
     * @return array
     */
    public function userFilter(string $q): array
    {
        return $this->repository->searchFilter($q);
    }
}
