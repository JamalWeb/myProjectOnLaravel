<?php

use common\components\PasswordHelper;
use common\components\registry\AttributeRegistry;
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

        $this->createTable(TableRegistry::TABLE_NAME_USER, [
            AttributeRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор пользователя'),

            AttributeRegistry::TYPE_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор типа'),

            AttributeRegistry::ROLE_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор роли'),

            AttributeRegistry::EMAIL => $this->string()
                ->notNull()
                ->comment('Электронная почта'),

            AttributeRegistry::USERNAME => $this->string()
                ->comment('Никнейм'),

            AttributeRegistry::PASSWORD => $this->string()
                ->notNull()
                ->comment('Пароль'),

            AttributeRegistry::AUTH_KEY => $this->string()
                ->comment('Ключ необходимый для авторизации'),

            AttributeRegistry::STATUS_ID => $this->integer()
                ->defaultValue(0)
                ->comment('Идентификатор статуса'),

            AttributeRegistry::LOGGED_IN_IP => $this->string()
                ->comment('IP адрес авторизации'),

            AttributeRegistry::LOGGED_IN_AT => $this->timestamp()
                ->comment('Дата авторизации'),

            AttributeRegistry::LOGOUT_IN_IP => $this->string()
                ->comment('IP адрес выхода'),

            AttributeRegistry::LOGOUT_IN_AT => $this->timestamp()
                ->comment('Дата выхода'),

            AttributeRegistry::CREATED_IP => $this->string()
                ->comment('IP адрес с которого создали'),

            AttributeRegistry::IS_BANNED => $this->boolean()
                ->defaultValue(false)
                ->comment('Бан (1 - вкл. 0 - выкл.) | default = 0'),

            AttributeRegistry::BANNED_REASON => $this->string()
                ->comment('Причина бана'),

            AttributeRegistry::BANNED_AT => $this->timestamp()
                ->comment('Дата бана'),

            AttributeRegistry::CREATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата создания'),

            AttributeRegistry::UPDATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата обновления'),
        ]);

        $this->insert(TableRegistry::TABLE_NAME_USER, [
            AttributeRegistry::TYPE_ID  => 1,
            AttributeRegistry::ROLE_ID  => UserRegistry::USER_ROLE_ADMIN,
            AttributeRegistry::EMAIL    => 'arsen-web@yandex.ru',
            AttributeRegistry::PASSWORD => PasswordHelper::encrypt(123456),
            AttributeRegistry::STATUS_ID   => UserRegistry::USER_STATUS_ACTIVE
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::TABLE_NAME_USER);
    }
}
