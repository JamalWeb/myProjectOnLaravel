<?php

namespace backend\Entity\Services\User\Repository;

use backend\Entity\Services\User\Dto\UserCreateDto;

interface UserRepositoryInterface
{
    public function create(UserCreateDto $dto);

}
