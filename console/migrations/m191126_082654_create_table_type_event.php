<?php

use common\components\registry\AttrRegistry;
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
        $this->createTable(TableRegistry::NAME_EVENT_TYPE, [
            AttrRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор типа события'),

            AttrRegistry::NAME => $this->string()
                ->notNull()
                ->comment('Наименование типа события'),

            AttrRegistry::DESCRIPTION => $this->string()
                ->comment('Описание типа события'),
        ]);

        $this->batchInsert(
            TableRegistry::NAME_EVENT_TYPE,
            [
                AttrRegistry::NAME,
                AttrRegistry::DESCRIPTION
            ],
            [
                [
                    AttrRegistry::NAME        => 'One-day event',
                    AttrRegistry::DESCRIPTION => 'Событие на один день'
                ],
                [
                    AttrRegistry::NAME        => 'Multiple-days event',
                    AttrRegistry::DESCRIPTION => 'Событие на несколько дней'
                ],
                [
                    AttrRegistry::NAME        => 'Regular event',
                    AttrRegistry::DESCRIPTION => 'Повторяющееся событие'
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::NAME_EVENT_TYPE);
    }
}
