<?php

namespace common\components\registry;

use common\models\user\UserRole;
use common\models\user\UserStatus;
use common\models\user\UserType;

class RgUser
{
    /* Роли */
    const ROLE_ADMIN = 1;
    const ROLE_DEFAULT = 2;
    const ROLE_BUSINESS = 3;

    /* Статусы */
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_UNCONFIRMED_EMAIL = 3;

    /* Типы */
    const TYPE_SYSTEM = 1;
    const TYPE_DEFAULT = 2;
    const TYPE_BUSINESS = 3;

    /* Типы токенов */
    const TOKEN_TYPE_AUTH = 1;
    const TOKEN_TYPE_RESET_AUTH = 2;
    const TOKEN_TYPE_PASSWORD_CHANGE = 3;
    const TOKEN_TYPE_EMAIL_CONFIRM = 4;
    const TOKEN_TYPE_EMAIL_CHANGE = 5;
    const TOKEN_TYPE_USER_RECOVERY = 6;

    public static $tokenTypeList = [
        self::TOKEN_TYPE_AUTH,
        self::TOKEN_TYPE_RESET_AUTH,
        self::TOKEN_TYPE_PASSWORD_CHANGE,
        self::TOKEN_TYPE_EMAIL_CONFIRM,
        self::TOKEN_TYPE_EMAIL_CHANGE,
        self::TOKEN_TYPE_USER_RECOVERY,
    ];

    /**
     * Список статусов
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return UserStatus::find()->all();
    }

    /**
     * Список ролей
     *
     * @param bool $systemRoles
     * @return array
     */
    public static function getRoleList(bool $systemRoles = false): array
    {
        $excludeRole = $systemRoles ? [] : [
            self::ROLE_ADMIN
        ];

        return UserRole::find()
            ->filterWhere(['NOT IN', 'id', $excludeRole])
            ->all();
    }

    /**
     * Список типов
     *
     * @param bool $systemTypes
     * @return array
     */
    public static function getTypeList(bool $systemTypes = false): array
    {
        $excludeTypes = $systemTypes ? [] : [
            self::TYPE_SYSTEM
        ];

        return UserType::find()
            ->filterWhere(['NOT IN', 'id', $excludeTypes])
            ->all();
    }
}
