<?php

use common\components\registry\AttrRegistry;
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

        $this->createTable(TableRegistry::NAME_USER_PROFILE, [
            AttrRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор профиля'),

            AttrRegistry::USER_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор пользователя'),

            AttrRegistry::FIRST_NAME => $this->string()
                ->notNull()
                ->comment('Имя'),

            AttrRegistry::LAST_NAME => $this->string()
                ->comment('Фамилия'),

            AttrRegistry::PATRONYMIC => $this->string()
                ->comment('Отчество'),

            AttrRegistry::AVATAR => $this->string()
                ->comment('Аватар'),

            AttrRegistry::PHONE_NUMBER => $this->string()
                ->comment('Телефонный номер'),

            AttrRegistry::ADDRESS => $this->string()
                ->comment('Адрес'),

            AttrRegistry::GENDER_ID => $this->integer()
                ->comment('Идентификатор пола'),

            AttrRegistry::ABOUT => $this->string()
                ->comment('Описание бизнес аккаунта'),

            AttrRegistry::COUNTRY_ID => $this->integer()
                ->comment('Идентификатор страны'),

            AttrRegistry::CITY_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор города'),

            AttrRegistry::IS_CLOSED => $this->boolean()
                ->defaultValue(false)
                ->comment('Профиль закрыт'),

            AttrRegistry::IS_NOTICE => $this->boolean()
                ->defaultValue(false)
                ->comment('Получать уведомления'),

            AttrRegistry::LONGITUDE => $this->string()
                ->comment('Координаты: долгота'),

            AttrRegistry::LATITUDE => $this->string()
                ->comment('Координаты: широта'),

            AttrRegistry::LANGUAGE => $this->string()
                ->comment('Язык'),

            AttrRegistry::SHORT_LANG => $this->string()
                ->comment('Код языка'),

            AttrRegistry::TIMEZONE => $this->string()
                ->comment('Часовой пояс'),

            AttrRegistry::CREATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата создания'),

            AttrRegistry::UPDATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата обновления'),
        ]);

        $this->batchInsert(
            TableRegistry::NAME_USER_PROFILE,
            [
                AttrRegistry::USER_ID,
                AttrRegistry::FIRST_NAME,
                AttrRegistry::CITY_ID,
                AttrRegistry::GENDER_ID,
                AttrRegistry::LANGUAGE,
                AttrRegistry::SHORT_LANG,
                AttrRegistry::TIMEZONE,
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
        $this->dropTable(TableRegistry::NAME_USER_PROFILE);
    }
}
