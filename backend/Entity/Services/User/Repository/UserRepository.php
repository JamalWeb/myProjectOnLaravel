<?php

namespace backend\Entity\Services\User\Repository;

use backend\Entity\Services\User\Dto\UserCreateDto;
use common\components\DateHelper;
use common\components\registry\RgUser;
use common\helpers\UserPermissionsHelper;
use common\models\user\User;
use Throwable;
use yii\db\Connection;
use yii\db\Exception;

class UserRepository implements UserRepositoryInterface
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param UserCreateDto $dto
     * @return mixed
     * @throws Throwable
     */
    public function create(UserCreateDto $dto)
    {
        return $this->connection->transaction(
            function () use ($dto) {
                $this->connection->createCommand()
                    ->insert(
                        '{{%user}}',
                        [
                            'username'  => $dto->userName,
                            'email'     => $dto->email,
                            'type_id'   => $dto->typeId,
                            'password'  => $dto->password,
                            'auth_key'  => $dto->authKey,
                            'status_id' => $dto->statusId,
                            'role_id'   => $dto->roleId,
                        ]
                    )->execute();
                $userId = $this->connection->getLastInsertID();

                $this->connection->createCommand()
                    ->insert(
                        '{{%user_profile}}',
                        [
                            'user_id'    => $userId,
                            'first_name' => $dto->firstName,
                            'gender_id'  => $dto->genderId,
                            'city_id'    => $dto->cityId,
                            'country_id' => $dto->countryId,
                        ]
                    )->execute();

                $this->connection->createCommand()
                    ->insert(
                        '{{%user_token}}',
                        [
                            'user_id'      => $userId,
                            'type_id'      => RgUser::TOKEN_TYPE_EMAIL_CONFIRM,
                            'access_token' => $dto->accessToken,
                            'expired_at'   => DateHelper::getTimestamp(),
                        ]
                    )->execute();

                UserPermissionsHelper::addRole($dto->role, $userId);

                return true;
            }
        );
    }

    /**
     * @param int $userID
     * @return int
     * @throws Exception
     */
    public function deleteAuthAssigment(int $userID)
    {
        return $this->connection->createCommand()->delete(
            '{{%auth_assignment}}',
            [
                'user_id' => $userID
            ]
        )->execute();
    }


    /**
     * @param User $user
     * @return bool|null
     * @throws Throwable
     */
    public function deleteUser(User $user): ?bool
    {
        return $this->connection->transaction(
            function () use ($user) {
                $user->delete();

                $this->deleteAuthAssigment($user->id);

                return true;
            }
        );
    }
}
