<?php


namespace console\controllers;


use common\helpers\UserPermissionsHelper;
use Yii;
use yii\base\Exception;
use yii\console\Controller;
use yii\helpers\Console;

class RbacController extends Controller
{
    /**
     * @param int $idAdminUser
     * @return bool|int
     * @throws Exception
     */
    public function actionInit(int $idAdminUser)
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

        $authManager->assign($admin, $idAdminUser);

        return $this->stdout('Success init rbac' . PHP_EOL, Console::FG_GREEN);
    }

    /**
     * @param int $userID
     * @param string $role
     * @return bool|int
     * @throws \Exception
     */
    public function actionAddRole(int $userID, string $role)
    {
        $roleCorrect = ucfirst($role);

        $add = UserPermissionsHelper::addRole($roleCorrect, $userID);

        if ($add === null) {
            return $this->stdout(
                "The role {$roleCorrect} for the user with the ID: {$userID} already exists" . PHP_EOL,
                Console::FG_RED
            );
        }
        return $this->stdout(
            "Success added role {$add->roleName} for {$userID}" . PHP_EOL,
            Console::FG_GREEN
        );
    }

    /**
     * @return bool|int
     */
    public function actionRemoveAll()
    {
        try {
            $authManager = Yii::$app->getAuthManager();
            $authManager->removeAll();

            return $this->stdout('Success removed' . PHP_EOL, Console::FG_GREEN);
        } catch (\Exception $exception) {
            return $this->stdout($exception->getMessage() . PHP_EOL . $exception->getTraceAsString(), Console::FG_RED);
        }
    }

}
