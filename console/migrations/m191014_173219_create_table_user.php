<?php

use common\components\PasswordHelper;
use common\components\registry\Constants;
use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m191014_173219_create_table_user
 */
class m191014_173219_create_table_user extends Migration
{
    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function safeUp()
    {
        $defaultDate = new Expression('CURRENT_TIMESTAMP');

        $this->createTable(Constants::TABLE_NAME_USER, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор пользователя'),

            'type_id' => $this->integer()
                ->notNull()
                ->comment('Идентификатор типа'),

            'role_id' => $this->integer()
                ->notNull()
                ->comment('Идентификатор роли'),

            'email' => $this->string()
                ->notNull()
                ->comment('Электронная почта'),

            'username' => $this->string()
                ->comment('Никнейм'),

            'password' => $this->string()
                ->notNull()
                ->comment('Пароль'),

            'auth_key' => $this->string()
                ->comment('Ключ необходимый для авторизации'),

            'status' => $this->integer()
                ->defaultValue(0)
                ->comment('Статус'),

            'logged_in_ip' => $this->string()
                ->comment('IP адрес авторизации'),

            'logged_in_at' => $this->timestamp()
                ->comment('Дата авторизации'),

            'logout_in_ip' => $this->string()
                ->comment('IP адрес выхода'),

            'logout_in_at' => $this->timestamp()
                ->comment('Дата выхода'),

            'created_ip' => $this->string()
                ->comment('IP адрес с которого создали'),

            'is_banned' => $this->boolean()
                ->defaultValue(false)
                ->comment('Бан (1 - вкл. 0 - выкл.) | default = 0'),

            'banned_reason' => $this->string()
                ->comment('Причина бана'),

            'banned_at' => $this->timestamp()
                ->comment('Дата бана'),

            'created_at' => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата создания'),

            'updated_at' => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата обновления'),
        ]);

        $this->insert(Constants::TABLE_NAME_USER, [
            'type_id'  => 1,
            'role_id'  => 1,
            'email'    => 'arsen-web@yandex.ru',
            'password' => PasswordHelper::encrypt(123456),
            'status'   => 1
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Constants::TABLE_NAME_USER);
    }
}
