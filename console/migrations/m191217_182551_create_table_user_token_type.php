<?php

use common\components\registry\AttributeRegistry;
use common\components\registry\TableRegistry;
use yii\db\Migration;

/**
 * Class m191217_182551_create_table_user_token_type
 */
class m191217_182551_create_table_user_token_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(TableRegistry::TABLE_NAME_USER_TOKEN_TYPE, [
            AttributeRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор типа токена'),

            AttributeRegistry::NAME => $this->string()
                ->notNull()
                ->comment('Наименование типа токена'),

            AttributeRegistry::DESCRIPTION => $this->string()
                ->comment('Описание типа токена'),
        ]);

        $this->batchInsert(TableRegistry::TABLE_NAME_USER_TOKEN_TYPE, [AttributeRegistry::NAME], [
            [AttributeRegistry::NAME => 'Авторизация'],
            [AttributeRegistry::NAME => 'Сброс авторизации'],
            [AttributeRegistry::NAME => 'Изменение пароля'],
            [AttributeRegistry::NAME => 'Подтверждение по электронной почте'],
            [AttributeRegistry::NAME => 'Изменение электронной почты'],
            [AttributeRegistry::NAME => 'Восстановление пользователя']
        ]);

        $this->addForeignKey(
            'FGK-type_id-user_token_type',
            TableRegistry::TABLE_NAME_USER_TOKEN,
            AttributeRegistry::TYPE_ID,
            TableRegistry::TABLE_NAME_USER_TOKEN_TYPE,
            AttributeRegistry::ID
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-type_id-user_token_type', TableRegistry::TABLE_NAME_USER_TOKEN);
        $this->dropTable(TableRegistry::TABLE_NAME_USER_TOKEN_TYPE);
    }
}
