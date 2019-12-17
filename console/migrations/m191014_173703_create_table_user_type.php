<?php

use common\components\registry\AttributeRegistry;
use common\components\registry\TableRegistry;
use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m191014_173703_create_table_user_type
 */
class m191014_173703_create_table_user_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $defaultDate = new Expression('CURRENT_TIMESTAMP');

        $this->createTable(TableRegistry::TABLE_NAME_USER_TYPE, [
            AttributeRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор типа'),

            AttributeRegistry::NAME => $this->string()
                ->notNull()
                ->comment('Наименование'),

            AttributeRegistry::DESCRIPTION => $this->string()
                ->comment('Описание'),

            AttributeRegistry::CREATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата создания'),

            AttributeRegistry::UPDATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата обновления')
        ]);

        $this->batchInsert(
            TableRegistry::TABLE_NAME_USER_TYPE,
            [
                AttributeRegistry::NAME,
                AttributeRegistry::DESCRIPTION
            ],
            [
                [
                    AttributeRegistry::NAME => 'System',
                    AttributeRegistry::DESCRIPTION => 'Системный пользователь'
                ],
                [
                    AttributeRegistry::NAME => 'User',
                    AttributeRegistry::DESCRIPTION => 'Обычный пользователь'
                ],
                [
                    AttributeRegistry::NAME => 'Business',
                    AttributeRegistry::DESCRIPTION => 'Бизнес пользователь'
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::TABLE_NAME_USER_TYPE);
    }
}
