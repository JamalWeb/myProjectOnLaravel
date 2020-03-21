<?php


namespace backend\Entity\Services\User;


use backend\Entity\Services\User\Dto\UserLoginDto;
use backend\Entity\Services\User\Repository\UserRepositoryInterface;

class UserService
{
    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function signIn(UserLoginDto $userLoginDto)
    {
    }


}