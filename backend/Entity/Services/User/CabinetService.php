<?php

namespace backend\Entity\Services\User;

use backend\Entity\Services\User\Dto\UserProfileDto;
use backend\Entity\Services\User\Repository\ProfileRepositoryInterface;

class CabinetService
{
    /** @var ProfileRepositoryInterface */
    private $repository;

    /**
     * CabinetService constructor.
     * @param ProfileRepositoryInterface $repository
     */
    public function __construct(ProfileRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function save(UserProfileDto $dto)
    {
        return $this->repository->save($dto);
    }
}
