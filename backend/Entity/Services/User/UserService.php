<?php


namespace backend\Entity\Services\User;


use backend\Entity\Services\User\Dto\UserLoginDto;
use backend\Entity\Services\User\Repository\UserRepositoryInterface;
use Yii;

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

    public function signIn(UserLoginDto $userLoginDto): bool
    {
        return Yii::$app->user->login($userLoginDto->user, $userLoginDto->rememberMe ? 3600 * 24 * 30 : 0);
    }

}