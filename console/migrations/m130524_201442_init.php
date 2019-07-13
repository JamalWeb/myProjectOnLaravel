<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $this->createTable('{{%user_type}}', [
            'id'   => $this->primaryKey()->comment('Идентификатор типа пользователя'),
            'name' => $this->string()->notNull()->comment('Название'),
            'desc' => $this->string()->comment('Описание'),
        ]);

        $this->batchInsert('{{%user_type}}', ['name', 'desc'], [
            [
                'name' => 'User',
                'desc' => 'Обычный аккаунт'
            ],
            [
                'name' => 'Business',
                'desc' => 'Бизнес аккаунт'
            ],
        ]);

        $this->createTable('{{%user}}', [
            'id'           => $this->primaryKey()->comment('Идентификатор пользователя'),
            'user_type_id' => $this->bigInteger()->notNull()->comment('Идентификатор типа пользователя'),
            'email'        => $this->string()->notNull()->unique()->comment('Почтовый адрес'),
            'password'     => $this->string()->notNull()->comment('Пароль'),
            'token'        => $this->string()->notNull()->comment('Уникальный ключ идентификации'),
            'profile_id'   => $this->bigInteger()->notNull()->comment('Идентификатор профиля пользователя'),
            'is_banned'    => $this->boolean()->defaultValue(false)->comment('Бан (1 - вкл. 0 - выкл.) | default = 0'),
            'banned_at'    => $this->timestamp()->comment('Дата бана'),
            'login_in_ip'  => $this->string()->comment('Авторизация с IP'),
            'login_in_at'  => $this->timestamp()->comment('Дата входа'),
            'logout_in_at' => $this->timestamp()->comment('Дата выхода'),
            'created_at'   => $this->timestamp()->comment('Дата создания'),
            'updated_at'   => $this->timestamp()->comment('Дата последнего обновления'),
        ]);

        $this->createTable('{{%category_profile}}', [
            'id'   => $this->primaryKey()->comment('Идентификатор категории профиля'),
            'name' => $this->string()->notNull()->comment('Название'),
        ]);

        $this->createTable('{{%user_profile}}', [
            'id'                  => $this->primaryKey()->comment('Идентификатор профиля пользователя'),
            'user_id'             => $this->bigInteger()->notNull()->comment('Идентификатор пользователя'),
            'category_profile_id' => $this->string()->comment('Идентификатор категории пррофиля'),
            'name'                => $this->string()->notNull()->comment('Имя'),
            'surname'             => $this->string()->comment('Фамилия'),
            'patronymic'          => $this->string()->comment('Отчество'),
            'lang'                => $this->string()->comment('Язык'),
            'short_lang'          => $this->string()->comment('Код языка'),
            'about'               => $this->string()->comment('Описание бизнес аккаунта'),
            'country'             => $this->string()->comment('Страна'),
            'city'                => $this->string()->notNull()->comment('Город'),
            'longitude'           => $this->string()->comment('Координаты: долгота'),
            'latitude'            => $this->string()->comment('Координаты: широта'),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user_type}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%category_profile}}');
        $this->dropTable('{{%user_profile}}');
    }
}
