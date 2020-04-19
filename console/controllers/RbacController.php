<?php


namespace console\controllers;


use backend\Entity\Services\User\Dto\UserCreateDto;
use backend\Entity\Services\User\UserService;
use common\components\PasswordHelper;
use common\components\registry\RgUser;
use common\helpers\UserPermissionsHelper;
use common\models\user\User;
use Yii;
use yii\base\Exception;
use yii\console\Controller;
use yii\helpers\Console;
use yii2mod\helpers\ArrayHelper;

class RbacController extends Controller
{
    private $service;

    public function __construct($id, $module, UserService $service, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
    }

    /**
     * @param int $idAdminUser
     * @return bool|int
     * @throws Exception
     */
    public function actionInit()
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

    /**
     * @return bool|int
     * @throws Exception
     */
    public function actionInitSystemUser()
    {
        $dto = new UserCreateDto();
        $dto->statusId = RgUser::STATUS_ACTIVE;
        $dto->typeId = RgUser::TYPE_SYSTEM;
        $dto->authKey = Yii::$app->security->generateRandomString();
        $dto->accessToken = Yii::$app->security->generateRandomString(34);
        $dto->cityId = 2;
        $dto->countryId = 1;
        $dto->genderId = 1;
        $dto->roleId = RgUser::ROLE_ADMIN;

        $dto->userName = $this->prompt(
            'Введите Username: ',
            [
                'required' => true
            ]
        );
        $dto->firstName = $dto->userName;

        $password = $this->prompt(
            'Введите пароль: ',
            [
                'required' => true
            ]
        );
        $dto->password = PasswordHelper::encrypt($password);

        $dto->email = $this->prompt(
            'Введите email: ',
            [
                'required' => true
            ]
        );

        if ($this->existsUser('email', $dto->email)) {
            return $this->stdout('User exists' . PHP_EOL, Console::FG_RED);
        }

        $dto->role = $this->select(
            'Select Role:',
            ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description')
        );

        $resultCreate = $this->service->repository->create($dto);
        $addRole = UserPermissionsHelper::addRole($dto->role, $resultCreate['userId']);

        $result = $resultCreate['result'] and $addRole !== null;
        if (!$result) {
            return $this->stdout('Все пошло по пизде');
        }

        return $this->stdout(
            <<<TEXT
Email: $dto->email
Password: $password
Role: $dto->role
TEXT
            ,
            Console::FG_GREEN
        );
    }


    /**
     * @param string $field
     * @param $value
     * @return bool
     */
    private function existsUser(string $field, $value): bool
    {
        return User::find()->where([$field => $value])->exists();
    }

}
