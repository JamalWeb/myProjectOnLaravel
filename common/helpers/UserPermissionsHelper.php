<?php

namespace common\helpers;

use common\models\AuthAssignment;
use Exception;
use Yii;
use yii\rbac\Assignment;
use yii\rbac\Role;
use yii2mod\helpers\ArrayHelper;

class UserPermissionsHelper
{
    /**
     * Роль модератор
     */
    public const ROLE_MODERATOR = 'Moderator';

    /**
     * Роль админ
     */
    public const ROLE_ADMIN = 'Admin';

    private static $usersRoles;

    /**
     * @param string $permission
     * @return bool
     */
    public static function isCan(string $permission): bool
    {
        return Yii::$app->user->can($permission);
    }

    /**
     * Вернет `true` если текущий пользователь имеет роль `Модератор`
     *
     * @param int|null $userID
     * @return bool
     */
    public static function isModerator(int $userID = null): bool
    {
        return self::hasRole(self::ROLE_MODERATOR, $userID);
    }

    /**
     * Вернет `true` если текущий пользователь имеет роль `Модератор`
     *
     * @param int|null $userID
     * @return bool
     */
    public static function isAdmin(int $userID = null): bool
    {
        return self::hasRole(self::ROLE_ADMIN, $userID);
    }


    /**
     * @param string $role
     * @param int|null $userID
     * @return bool
     */
    public static function hasRole(string $role, int $userID = null): bool
    {
        if ($userID === null) {
            $userID = Yii::$app->user->id;

            if (empty($userID)) {
                return false;
            }
        }

        return ArrayHelper::isIn($role, ArrayHelper::getColumn(self::getUserRoles($userID), 'name'));
    }

    public static function getUserModerator(): AuthAssignment
    {
        return AuthAssignment::find()->where(['item_name' => self::ROLE_MODERATOR])->one();
    }

    /**
     * Добавление роли
     *
     * @param string $role
     * @param int $userID
     * @param bool $rewrite - Если необходимо перезаписать роли
     * @return Assignment|null
     * @throws Exception
     */
    public static function addRole(string $role, int $userID, $rewrite = true): ?Assignment
    {
        /**
         * Если роль пуста или пользователь уже имеет необходимую роль и она у него одна - выходим
         * Если ролей несколько - отзываем все и присваиваем новую
         */
        if (
            empty($role) ||
            (self::hasRole($role, $userID) && count(self::getUserRoles($userID)) === 1)
        ) {
            return null;
        }

        $auth = Yii::$app->authManager;

        if ($rewrite) {
            $auth->revokeAll($userID);
        }

        return $auth->assign($auth->getRole($role), $userID);
    }

    /**
     * @param int $userID
     * @return Role[]
     */
    public static function getUserRoles(int $userID): array
    {
        if (!ArrayHelper::has(self::$usersRoles, $userID)) {
            self::$usersRoles[$userID] = Yii::$app->authManager->getRolesByUser($userID);
        }

        return self::$usersRoles[$userID];
    }
}
