<?php

use common\components\PasswordHelper;
use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
use common\components\registry\UserRegistry;
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

        $this->createTable(TableRegistry::NAME_USER, [
            AttrRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор пользователя'),

            AttrRegistry::TYPE_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор типа'),

            AttrRegistry::ROLE_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор роли'),

            AttrRegistry::EMAIL => $this->string()
                ->notNull()
                ->comment('Электронная почта'),

            AttrRegistry::USERNAME => $this->string()
                ->comment('Никнейм'),

            AttrRegistry::PASSWORD => $this->string()
                ->notNull()
                ->comment('Пароль'),

            AttrRegistry::AUTH_KEY => $this->string()
                ->comment('Ключ необходимый для авторизации'),

            AttrRegistry::STATUS_ID => $this->integer()
                ->defaultValue(0)
                ->comment('Идентификатор статуса'),

            AttrRegistry::LOGGED_IN_IP => $this->string()
                ->comment('IP адрес авторизации'),

            AttrRegistry::LOGGED_IN_AT => $this->timestamp()
                ->comment('Дата авторизации'),

            AttrRegistry::LOGOUT_IN_IP => $this->string()
                ->comment('IP адрес выхода'),

            AttrRegistry::LOGOUT_IN_AT => $this->timestamp()
                ->comment('Дата выхода'),

            AttrRegistry::CREATED_IP => $this->string()
                ->comment('IP адрес с которого создали'),

            AttrRegistry::IS_BANNED => $this->boolean()
                ->defaultValue(false)
                ->comment('Бан (1 - вкл. 0 - выкл.) | default = 0'),

            AttrRegistry::BANNED_REASON => $this->string()
                ->comment('Причина бана'),

            AttrRegistry::BANNED_AT => $this->timestamp()
                ->comment('Дата бана'),

            AttrRegistry::CREATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата создания'),

            AttrRegistry::UPDATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата обновления'),
        ]);

        $this->insert(TableRegistry::NAME_USER, [
            AttrRegistry::TYPE_ID   => 1,
            AttrRegistry::ROLE_ID   => UserRegistry::USER_ROLE_ADMIN,
            AttrRegistry::EMAIL     => 'arsen-web@yandex.ru',
            AttrRegistry::PASSWORD  => PasswordHelper::encrypt(123456),
            AttrRegistry::STATUS_ID => UserRegistry::USER_STATUS_ACTIVE
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::NAME_USER);
    }
}
