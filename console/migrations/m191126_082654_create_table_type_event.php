<?php

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
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
        $this->createTable(
            RgTable::NAME_EVENT_TYPE,
            [
                RgAttribute::ID => $this->primaryKey()
                    ->comment('Идентификатор типа события'),

                RgAttribute::NAME => $this->string()
                    ->notNull()
                    ->comment('Наименование типа события'),

                RgAttribute::DESCRIPTION => $this->string()
                    ->comment('Описание типа события'),
            ]
        );

        $this->batchInsert(
            RgTable::NAME_EVENT_TYPE,
            [
                RgAttribute::NAME,
                RgAttribute::DESCRIPTION
            ],
            [
                [
                    RgAttribute::NAME        => 'One-day event',
                    RgAttribute::DESCRIPTION => 'Событие на один день'
                ],
                [
                    RgAttribute::NAME        => 'Multiple-days event',
                    RgAttribute::DESCRIPTION => 'Событие на несколько дней'
                ],
                [
                    RgAttribute::NAME        => 'Regular event',
                    RgAttribute::DESCRIPTION => 'Повторяющееся событие'
                ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(RgTable::NAME_EVENT_TYPE);
    }
}
