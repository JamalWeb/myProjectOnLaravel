<?php

use common\components\registry\AttrRegistry;
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
        $this->createTable(TableRegistry::NAME_USER_TOKEN_TYPE, [
            AttrRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор типа токена'),

            AttrRegistry::NAME => $this->string()
                ->notNull()
                ->comment('Наименование типа токена'),

            AttrRegistry::DESCRIPTION => $this->string()
                ->comment('Описание типа токена'),
        ]);

        $this->batchInsert(TableRegistry::NAME_USER_TOKEN_TYPE, [AttrRegistry::NAME], [
            [AttrRegistry::NAME => 'Авторизация'],
            [AttrRegistry::NAME => 'Сброс авторизации'],
            [AttrRegistry::NAME => 'Изменение пароля'],
            [AttrRegistry::NAME => 'Подтверждение по электронной почте'],
            [AttrRegistry::NAME => 'Изменение электронной почты'],
            [AttrRegistry::NAME => 'Восстановление пользователя']
        ]);

        $this->addForeignKey(
            'FGK-type_id-user_token_type',
            TableRegistry::NAME_USER_TOKEN,
            AttrRegistry::TYPE_ID,
            TableRegistry::NAME_USER_TOKEN_TYPE,
            AttrRegistry::ID
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-type_id-user_token_type', TableRegistry::NAME_USER_TOKEN);
        $this->dropTable(TableRegistry::NAME_USER_TOKEN_TYPE);
    }
}
