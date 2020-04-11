<?php

namespace backend\Entity\Services\User\Repository;

use backend\Entity\Services\User\Dto\UserCreateDto;
use common\models\user\User;

interface UserRepositoryInterface
{
    public function create(UserCreateDto $dto);

    public function deleteAuthAssigment(int $userID);

    public function deleteUser(User $user);
}
