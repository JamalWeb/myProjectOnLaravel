<?php

use common\components\registry\Constants;
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

        $this->createTable(Constants::TABLE_NAME_USER_PROFILE, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор профиля'),

            'user_id' => $this->integer()
                ->notNull()
                ->comment('Идентификатор пользователя'),

            'first_name' => $this->string()
                ->notNull()
                ->comment('Имя'),

            'last_name' => $this->string()
                ->comment('Фамилия'),

            'patronymic' => $this->string()
                ->comment('Отчество'),

            'avatar' => $this->string()
                ->comment('Аватар'),

            'phone_number' => $this->string()
                ->comment('Телефонный номер'),

            'address' => $this->string()
                ->comment('Адрес'),

            'gender_id' => $this->integer()
                ->comment('Идентификатор пола'),

            'about' => $this->string()
                ->comment('Описание бизнес аккаунта'),

            'country_id' => $this->integer()
                ->comment('Идентификатор страны'),

            'city_id' => $this->integer()
                ->notNull()
                ->comment('Идентификатор города'),

            'is_closed' => $this->boolean()
                ->defaultValue(false)
                ->comment('Профиль закрыт'),

            'is_notice' => $this->boolean()
                ->defaultValue(false)
                ->comment('Получать уведомления'),

            'longitude' => $this->string()
                ->comment('Координаты: долгота'),

            'latitude' => $this->string()
                ->comment('Координаты: широта'),

            'language' => $this->string()
                ->comment('Язык'),

            'short_lang' => $this->string()
                ->comment('Код языка'),

            'timezone' => $this->string()
                ->comment('Часовой пояс'),

            'created_at' => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата создания'),

            'updated_at' => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата обновления'),
        ]);

        $this->batchInsert(Constants::TABLE_NAME_USER_PROFILE, [
            'user_id',
            'first_name',
            'city_id',
            'gender_id',
            'language',
            'short_lang',
            'timezone',
        ], [
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
        $this->dropTable(Constants::TABLE_NAME_USER_PROFILE);
    }
}
