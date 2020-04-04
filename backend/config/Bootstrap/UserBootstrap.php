<?php

namespace backend\config\Bootstrap;

use backend\Entity\Services\User\{AuthService,
    CabinetService,
    Repository\ProfileRepository,
    Repository\ProfileRepositoryInterface,
    Repository\UserRepository,
    Repository\UserRepositoryInterface
};
use UserService;
use Yii;
use yii\base\BootstrapInterface;

class UserBootstrap implements BootstrapInterface
{

    /**
     * @inheritDoc
     */
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $container->setSingleton(AuthService::class);
        $container->setSingleton(CabinetService::class);
        $container->setSingleton(UserService::class);

        $container->set(
            UserRepositoryInterface::class,
            static function () {
                return new UserRepository(Yii::$app->db);
            }
        );

        $container->set(
            ProfileRepositoryInterface::class,
            static function () {
                return new ProfileRepository(Yii::$app->db);
            }
        );
    }
}
