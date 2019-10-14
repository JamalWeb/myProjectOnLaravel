<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m191014_175740_create_table_user_profile
 */
class m191014_175740_create_table_user_profile extends Migration
{
    const TABLE_NAME = '{{%user_profile}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $defaultDate = new Expression('CURRENT_TIMESTAMP');

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор профиля'),

            'user_id' => $this->integer()
                ->notNull()
                ->comment('Идентификатор пользователя'),

            'first_name' => $this->string()
                ->comment('Имя'),

            'surname' => $this->string()
                ->comment('Фамилия'),

            'patronymic' => $this->string()
                ->comment('Отчество'),

            'gender_id' => $this->string()
                ->comment('Идентификатор пола'),

            'about' => $this->string()
                ->comment('Описание бизнес аккаунта'),

            'country' => $this->string()
                ->comment('Страна'),

            'city' => $this->string()
                ->comment('Город'),

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

        $this->batchInsert(self::TABLE_NAME, ['user_id', 'first_name'], [
            [1, 'Admin']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
