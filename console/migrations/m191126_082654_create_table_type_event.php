<?php

use common\components\registry\AttributeRegistry;
use common\components\registry\TableRegistry;
use yii\db\Migration;

/**
 * Class m191126_082654_create_table_type_event
 */
class m191126_082654_create_table_type_event extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(TableRegistry::TABLE_NAME_EVENT_TYPE, [
            AttributeRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор типа события'),

            AttributeRegistry::NAME => $this->string()
                ->notNull()
                ->comment('Наименование типа события'),

            AttributeRegistry::DESCRIPTION => $this->string()
                ->comment('Описание типа события'),
        ]);

        $this->batchInsert(
            TableRegistry::TABLE_NAME_EVENT_TYPE,
            [
                AttributeRegistry::NAME,
                AttributeRegistry::DESCRIPTION
            ],
            [
                [
                    AttributeRegistry::NAME        => 'One-day event',
                    AttributeRegistry::DESCRIPTION => 'Событие на один день'
                ],
                [
                    AttributeRegistry::NAME        => 'Multiple-days event',
                    AttributeRegistry::DESCRIPTION => 'Событие на несколько дней'
                ],
                [
                    AttributeRegistry::NAME        => 'Regular event',
                    AttributeRegistry::DESCRIPTION => 'Повторяющееся событие'
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::TABLE_NAME_EVENT_TYPE);
    }
}
