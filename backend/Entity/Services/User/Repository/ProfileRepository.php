<?php

namespace backend\Entity\Services\User\Repository;

use backend\Entity\Services\User\Dto\UserProfileDto;
use Throwable;
use yii\db\Connection;

class ProfileRepository implements ProfileRepositoryInterface
{
    private $connection;

    /**
     * ProfileRepository constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param UserProfileDto $dto
     * @return mixed
     * @throws Throwable
     */
    public function save(UserProfileDto $dto)
    {
        return $this->connection->transaction(
            function () use ($dto) {
                $this->connection->createCommand()->update(
                    '{{%user_profile}}',
                    [
                        'first_name'   => $dto->firstName,
                        'last_name'    => $dto->lastName,
                        'phone_number' => $dto->phoneNumber,
                        'patronymic'   => $dto->patronymic,
                        'address'      => $dto->address,
                        'gender_id'    => $dto->genderId,
                        'avatar'       => $dto->avatar,
                    ],
                    [
                        'user_id' => $dto->userId,
                    ]
                )->execute();

                $this->connection->createCommand()->update(
                    '{{%user}}',
                    [
                        'email'    => $dto->email,
                        'username' => $dto->username,
                        'password' => $dto->newPassword,
                    ],
                    [
                        'id' => $dto->userId,
                    ]
                )->execute();

                return true;
            }
        );
    }
}
