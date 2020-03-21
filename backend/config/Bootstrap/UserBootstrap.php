<?php

namespace backend\config\Bootstrap;

use backend\Entity\Services\User\AuthService;
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

        $container->set(
            UserRepositoryInterface::class,
            static function () {
                return new UserRepository(Yii::$app->db);
            }
        );
    }
}
