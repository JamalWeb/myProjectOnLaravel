<?php

namespace backend\Entity\Services\User;

use backend\Entity\Services\User\Dto\UserCreateDto;
use backend\Entity\Services\User\Repository\UserRepositoryInterface;
use common\components\EmailSender;
use common\helpers\UserPermissionsHelper;
use common\models\user\User;
use Exception;
use Throwable;
use Yii;
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

    /**
     * @param UserCreateDto $dto
     * @return bool
     */
    public function createUser(UserCreateDto $dto): bool
    {
        try {
            $resultSave = $this->repository->create($dto);

            if ($resultSave['result']) {
                UserPermissionsHelper::addRole($dto->role, $resultSave['userId']);
            }

            $sendEmail = EmailSender::registrationConfirmSystemUser($dto);

            return $resultSave['result'] && $sendEmail;
        } catch (Exception $exception) {
            Yii::error($exception->getMessage() . PHP_EOL . $exception->getTraceAsString(), 'createUser');
            return false;
        }
    }
}
