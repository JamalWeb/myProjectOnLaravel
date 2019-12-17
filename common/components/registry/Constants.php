<?php

namespace common\components\registry;

class Constants
{
    /* Наименование таблиц */
    const TABLE_NAME_USER = '{{%user}}';
    const TABLE_NAME_USER_ROLE = '{{%user_role}}';
    const TABLE_NAME_USER_TYPE = '{{%user_type}}';
    const TABLE_NAME_USER_PROFILE = '{{%user_profile}}';
    const TABLE_NAME_USER_GENDER = '{{%user_gender}}';
    const TABLE_NAME_USER_CHILDREN = '{{%user_children}}';
    const TABLE_NAME_USER_TOKEN = '{{%user_token}}';
    const TABLE_NAME_INTEREST_CATEGORY = '{{%interest_category}}';
    const TABLE_NAME_RELATION_USER_INTEREST = '{{%relation_user_interest}}';
    const TABLE_NAME_CITY = '{{%city}}';
    const TABLE_NAME_EVENT = '{{%event}}';
    const TABLE_NAME_EVENT_TYPE = '{{%event_type}}';
    const TABLE_NAME_EVENT_STATUS = '{{%event_status}}';
    const TABLE_NAME_EVENT_PHOTO_GALLERY = '{{%event_photo_gallery}}';
    const TABLE_NAME_EVENT_CARRYING_DATE = '{{%event_carrying_date}}';

    /* Роли пользователя */
    const USER_ROLE_ADMIN = 1;
    const USER_ROLE_DEFAULT_USER = 2;
    const USER_ROLE_BUSINESS_USER = 3;

    /* Статусы пользователя */
    const USER_STATUS_INACTIVE = 0;
    const USER_STATUS_ACTIVE = 1;
    const USER_STATUS_UNCONFIRMED_EMAIL = 2;

    public static $userStatuses = [
        Constants::USER_STATUS_INACTIVE          => 'Не активен',
        Constants::USER_STATUS_ACTIVE            => 'Активен',
        Constants::USER_STATUS_UNCONFIRMED_EMAIL => 'Почта не подтверждена',
    ];
}
