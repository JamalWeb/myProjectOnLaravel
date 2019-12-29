<?php

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
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

        $this->createTable(
            RgTable::NAME_USER_PROFILE,
            [
                RgAttribute::ID => $this->primaryKey()
                    ->comment('Идентификатор профиля'),

                RgAttribute::USER_ID => $this->integer()
                    ->notNull()
                    ->comment('Идентификатор пользователя'),

                RgAttribute::FIRST_NAME => $this->string()
                    ->notNull()
                    ->comment('Имя'),

                RgAttribute::LAST_NAME => $this->string()
                    ->comment('Фамилия'),

                RgAttribute::PATRONYMIC => $this->string()
                    ->comment('Отчество'),

                RgAttribute::AVATAR => $this->string()
                    ->comment('Аватар'),

                RgAttribute::PHONE_NUMBER => $this->string()
                    ->comment('Телефонный номер'),

                RgAttribute::ADDRESS => $this->string()
                    ->comment('Адрес'),

                RgAttribute::GENDER_ID => $this->integer()
                    ->comment('Идентификатор пола'),

                RgAttribute::ABOUT => $this->string()
                    ->comment('Описание бизнес аккаунта'),

                RgAttribute::COUNTRY_ID => $this->integer()
                    ->comment('Идентификатор страны'),

                RgAttribute::CITY_ID => $this->integer()
                    ->notNull()
                    ->comment('Идентификатор города'),

                RgAttribute::IS_CLOSED => $this->boolean()
                    ->defaultValue(false)
                    ->comment('Профиль закрыт'),

                RgAttribute::IS_NOTICE => $this->boolean()
                    ->defaultValue(false)
                    ->comment('Получать уведомления'),

                RgAttribute::LONGITUDE => $this->string()
                    ->comment('Координаты: долгота'),

                RgAttribute::LATITUDE => $this->string()
                    ->comment('Координаты: широта'),

                RgAttribute::LANGUAGE => $this->string()
                    ->comment('Язык'),

                RgAttribute::SHORT_LANG => $this->string()
                    ->comment('Код языка'),

                RgAttribute::TIMEZONE => $this->string()
                    ->comment('Часовой пояс'),

                RgAttribute::CREATED_AT => $this->timestamp()
                    ->defaultValue($defaultDate)
                    ->comment('Дата создания'),

                RgAttribute::UPDATED_AT => $this->timestamp()
                    ->defaultValue($defaultDate)
                    ->comment('Дата обновления'),
            ]
        );

        $this->batchInsert(
            RgTable::NAME_USER_PROFILE,
            [
                RgAttribute::USER_ID,
                RgAttribute::FIRST_NAME,
                RgAttribute::CITY_ID,
                RgAttribute::GENDER_ID,
                RgAttribute::LANGUAGE,
                RgAttribute::SHORT_LANG,
                RgAttribute::TIMEZONE,
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
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(RgTable::NAME_USER_PROFILE);
    }
}
