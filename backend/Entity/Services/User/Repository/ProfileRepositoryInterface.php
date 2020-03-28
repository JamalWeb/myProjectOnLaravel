<?php

namespace backend\Entity\Services\User\Repository;

use backend\Entity\Services\User\Dto\UserProfileDto;

interface ProfileRepositoryInterface
{
    public function save(UserProfileDto $dto);
}
