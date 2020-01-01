<?php

use common\components\PasswordHelper;
use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use common\components\registry\RgUser;
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

        $this->createTable(
            RgTable::NAME_USER,
            [
                RgAttribute::ID => $this->primaryKey()
                    ->comment('Идентификатор пользователя'),

                RgAttribute::TYPE_ID => $this->integer()
                    ->notNull()
                    ->comment('Идентификатор типа'),

                RgAttribute::ROLE_ID => $this->integer()
                    ->notNull()
                    ->comment('Идентификатор роли'),

                RgAttribute::EMAIL => $this->string()
                    ->notNull()
                    ->comment('Электронная почта'),

                RgAttribute::USERNAME => $this->string()
                    ->comment('Никнейм'),

                RgAttribute::PASSWORD => $this->string()
                    ->notNull()
                    ->comment('Пароль'),

                RgAttribute::AUTH_KEY => $this->string()
                    ->comment('Ключ необходимый для авторизации'),

                RgAttribute::STATUS_ID => $this->integer()
                    ->defaultValue(0)
                    ->comment('Идентификатор статуса'),

                RgAttribute::LOGGED_IN_IP => $this->string()
                    ->comment('IP адрес авторизации'),

                RgAttribute::LOGGED_IN_AT => $this->timestamp()
                    ->comment('Дата авторизации'),

                RgAttribute::LOGOUT_IN_IP => $this->string()
                    ->comment('IP адрес выхода'),

                RgAttribute::LOGOUT_IN_AT => $this->timestamp()
                    ->comment('Дата выхода'),

                RgAttribute::CREATED_IP => $this->string()
                    ->comment('IP адрес с которого создали'),

                RgAttribute::IS_BANNED => $this->boolean()
                    ->defaultValue(false)
                    ->comment('Бан (1 - вкл. 0 - выкл.) | default = 0'),

                RgAttribute::BANNED_REASON => $this->string()
                    ->comment('Причина бана'),

                RgAttribute::BANNED_AT => $this->timestamp()
                    ->comment('Дата бана'),

                RgAttribute::CREATED_AT => $this->timestamp()
                    ->defaultValue($defaultDate)
                    ->comment('Дата создания'),

                RgAttribute::UPDATED_AT => $this->timestamp()
                    ->defaultValue($defaultDate)
                    ->comment('Дата обновления'),
            ]
        );

        $this->insert(
            RgTable::NAME_USER,
            [
                RgAttribute::TYPE_ID   => 1,
                RgAttribute::ROLE_ID   => RgUser::ROLE_ADMIN,
                RgAttribute::EMAIL     => 'arsen-web@yandex.ru',
                RgAttribute::PASSWORD  => PasswordHelper::encrypt(123456),
                RgAttribute::STATUS_ID => RgUser::STATUS_ACTIVE
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(RgTable::NAME_USER);
    }
}
