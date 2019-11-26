<?php

use yii\db\Migration;

/**
 * Class m191126_082654_create_table_type_event
 */
class m191126_082654_create_table_type_event extends Migration
{
    const TABLE_NAME_EVENT_TYPE = '{{%event_type}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME_EVENT_TYPE, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор типа события'),

            'name' => $this->string()
                ->notNull()
                ->comment('Наименование типа события'),

            'desc' => $this->string()
                ->comment('Описание типа события'),
        ]);

        $this->batchInsert(self::TABLE_NAME_EVENT_TYPE, ['name', 'desc'], [
            [
                'name' => 'One-day event',
                'desc' => 'Событие на один день'
            ],
            [
                'name' => 'Multiple-days event',
                'desc' => 'Событие на несколько дней'
            ],
            [
                'name' => 'Regular event',
                'desc' => 'Повторяющееся событие'
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME_EVENT_TYPE);
    }
}
