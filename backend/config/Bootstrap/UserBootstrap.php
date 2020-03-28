<?php

namespace backend\config\Bootstrap;

use backend\Entity\Services\User\AuthService;
use backend\Entity\Services\User\CabinetService;
use backend\Entity\Services\User\Repository\ProfileRepository;
use backend\Entity\Services\User\Repository\ProfileRepositoryInterface;
use backend\Entity\Services\User\Repository\UserRepository;
use backend\Entity\Services\User\Repository\UserRepositoryInterface;
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
