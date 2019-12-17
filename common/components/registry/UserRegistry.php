<?php

namespace common\components\registry;

class UserRegistry
{
    /* Статусы пользователя */
    const USER_STATUS_INACTIVE = 1;
    const USER_STATUS_ACTIVE = 2;
    const USER_STATUS_UNCONFIRMED_EMAIL = 3;

    /* Роли пользователя */
    const USER_ROLE_ADMIN = 1;
    const USER_ROLE_DEFAULT_USER = 2;
    const USER_ROLE_BUSINESS_USER = 3;

    /* Список статусов пользователя */
    public static $userStatuses = [
        self::USER_STATUS_INACTIVE          => 'Не активен',
        self::USER_STATUS_ACTIVE            => 'Активен',
        self::USER_STATUS_UNCONFIRMED_EMAIL => 'Почта не подтверждена'
    ];

    /**
     * Название статуса по ID
     *
     * @param int $id
     * @return string
     */
    public static function getStatusNameById(int $id): string
    {
        return self::$userStatuses[$id];
    }
}
