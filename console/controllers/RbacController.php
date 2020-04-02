<?php


namespace console\controllers;


use common\models\user\User;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit(): void
    {
        $authManager = Yii::$app->getAuthManager();
        $authManager->removeAll();

        $admin = $authManager->createRole('Admin');
        $moderator = $authManager->createRole('Moderator');

        $authManager->add($admin);
        $authManager->add($moderator);

        $moderationOfEvents = $authManager->createPermission('moderationOfEvents');
        $moderationOfEvents->description = 'Модерация событий';

        $moderationOfBusinessProfile = $authManager->createPermission('moderationOfBusinessProfile');
        $moderationOfBusinessProfile->description = 'Модерация бизнес профилей';

        $createUsers = $authManager->createPermission('createUsers');
        $createUsers->description = 'Создание пользователей';

        $authManager->add($moderationOfEvents);
        $authManager->add($moderationOfBusinessProfile);
        $authManager->add($createUsers);

        $authManager->addChild($moderator, $moderationOfEvents);
        $authManager->addChild($moderator, $moderationOfBusinessProfile);
        $authManager->addChild($admin, $createUsers);

        $authManager->addChild($admin, $moderator);

        $authManager->assign($admin, $this->findUser());
    }

    /**
     * @return int
     */
    public function findUser(): int
    {
        return User::findOne(['username' => 'jamalWeb'])->id;
    }

}
