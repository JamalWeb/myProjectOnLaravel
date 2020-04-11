<?php

namespace backend\Entity\Services\User;

use backend\Entity\Services\User\Dto\UserCreateDto;
use backend\Entity\Services\User\Repository\UserRepositoryInterface;
use common\components\EmailSendler;
use common\models\user\User;
use Throwable;
use yii\web\NotFoundHttpException;

class UserService
{
    public $repository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $field
     * @param $value
     * @return User|null
     * @throws NotFoundHttpException
     */
    public function findOne(string $field, $value): ?User
    {
        $this->validateExists($field, $value);

        return User::findOne([$field => $value]);
    }

    /**
     * @param int $id
     * @return bool
     * @throws Throwable
     */
    public function deleteUser(int $id): bool
    {
        $user = $this->findOne('id', $id);

        return $this->repository->deleteUser($user);
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

    public function createUser(UserCreateDto $dto): bool
    {
        try {
            $resultSave = $this->repository->create($dto);
            $sendEmail = EmailSendler::registrationConfirmSystemUser($dto);

            return $resultSave && $sendEmail;
        } catch (\Exception $exception) {
            throw new $exception;
        }
    }
}
