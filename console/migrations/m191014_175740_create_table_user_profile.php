<?php

use common\components\registry\AttributeRegistry;
use common\components\registry\TableRegistry;
use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m191014_175740_create_table_user_profile
 */
class m191014_175740_create_table_user_profile extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $defaultDate = new Expression('CURRENT_TIMESTAMP');

        $this->createTable(TableRegistry::TABLE_NAME_USER_PROFILE, [
            AttributeRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор профиля'),

            AttributeRegistry::USER_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор пользователя'),

            AttributeRegistry::FIRST_NAME => $this->string()
                ->notNull()
                ->comment('Имя'),

            AttributeRegistry::LAST_NAME => $this->string()
                ->comment('Фамилия'),

            AttributeRegistry::PATRONYMIC => $this->string()
                ->comment('Отчество'),

            AttributeRegistry::AVATAR => $this->string()
                ->comment('Аватар'),

            AttributeRegistry::PHONE_NUMBER => $this->string()
                ->comment('Телефонный номер'),

            AttributeRegistry::ADDRESS => $this->string()
                ->comment('Адрес'),

            AttributeRegistry::GENDER_ID => $this->integer()
                ->comment('Идентификатор пола'),

            AttributeRegistry::ABOUT => $this->string()
                ->comment('Описание бизнес аккаунта'),

            AttributeRegistry::COUNTRY_ID => $this->integer()
                ->comment('Идентификатор страны'),

            AttributeRegistry::CITY_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор города'),

            AttributeRegistry::IS_CLOSED => $this->boolean()
                ->defaultValue(false)
                ->comment('Профиль закрыт'),

            AttributeRegistry::IS_NOTICE => $this->boolean()
                ->defaultValue(false)
                ->comment('Получать уведомления'),

            AttributeRegistry::LONGITUDE => $this->string()
                ->comment('Координаты: долгота'),

            AttributeRegistry::LATITUDE => $this->string()
                ->comment('Координаты: широта'),

            AttributeRegistry::LANGUAGE => $this->string()
                ->comment('Язык'),

            AttributeRegistry::SHORT_LANG => $this->string()
                ->comment('Код языка'),

            AttributeRegistry::TIMEZONE => $this->string()
                ->comment('Часовой пояс'),

            AttributeRegistry::CREATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата создания'),

            AttributeRegistry::UPDATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата обновления'),
        ]);

        $this->batchInsert(
            TableRegistry::TABLE_NAME_USER_PROFILE,
            [
                AttributeRegistry::USER_ID,
                AttributeRegistry::FIRST_NAME,
                AttributeRegistry::CITY_ID,
                AttributeRegistry::GENDER_ID,
                AttributeRegistry::LANGUAGE,
                AttributeRegistry::SHORT_LANG,
                AttributeRegistry::TIMEZONE,
            ],
            [
                [
                    1,
                    'Admin',
                    1,
                    1,
                    'Russian',
                    'ru-RU',
                    'Europe/Moscow',
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::TABLE_NAME_USER_PROFILE);
    }
}
