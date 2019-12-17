<?php

use common\components\registry\AttributeRegistry;
use common\components\registry\TableRegistry;
use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m191014_174852_create_table_user_role
 */
class m191014_174852_create_table_user_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $defaultDate = new Expression('CURRENT_TIMESTAMP');

        $this->createTable(TableRegistry::TABLE_NAME_USER_ROLE, [
            AttributeRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор роли'),

            AttributeRegistry::NAME => $this->string()
                ->notNull()
                ->comment('Наименование роли'),

            AttributeRegistry::DESCRIPTION => $this->string()
                ->notNull()
                ->comment('Описание роли'),

            AttributeRegistry::CREATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата создания'),

            AttributeRegistry::UPDATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата обновления')
        ]);

        $this->batchInsert(
            TableRegistry::TABLE_NAME_USER_ROLE,
            [
                AttributeRegistry::NAME,
                AttributeRegistry::DESCRIPTION
            ],
            [
                [
                    'Admin',
                    'Администратор',
                ],
                [
                    'User',
                    'Обычный пользователь'
                ],
                [
                    'Business',
                    'Бизнес пользователь'
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::TABLE_NAME_USER_ROLE);
    }
}
