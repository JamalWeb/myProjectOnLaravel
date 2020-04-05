<?php

namespace backend\Entity\Services\User\Repository;

use backend\Entity\Services\User\Dto\UserCreateDto;
use common\components\DateHelper;
use common\components\registry\RgUser;
use common\helpers\UserPermissionsHelper;
use Throwable;
use yii\db\Connection;
use yii\db\Expression;

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
                $this->connection->createCommand(new Expression('return id'))
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
}
