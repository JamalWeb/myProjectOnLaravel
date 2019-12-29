<?php

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
use yii\db\Migration;

/**
 * Class m191212_071929_create_table_event_status
 */
class m191212_071929_create_table_event_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(TableRegistry::NAME_EVENT_STATUS, [
            AttrRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор статуса события'),

            AttrRegistry::NAME => $this->string()
                ->comment('Наименование статуса события'),

            AttrRegistry::DESCRIPTION => $this->string()
                ->comment('Описание статуса события'),
        ]);

        $this->batchInsert(
            TableRegistry::NAME_EVENT_STATUS,
            [
                AttrRegistry::NAME,
                AttrRegistry::DESCRIPTION
            ],
            [
                [
                    AttrRegistry::NAME        => 'Новое',
                    AttrRegistry::DESCRIPTION => 'Новое событие'
                ],
                [
                    AttrRegistry::NAME        => 'Завершено',
                    AttrRegistry::DESCRIPTION => 'Событие было завершено'
                ],
                [
                    AttrRegistry::NAME        => 'Отменено',
                    AttrRegistry::DESCRIPTION => 'Событие было отменено'
                ],
                [
                    AttrRegistry::NAME        => 'Не активно',
                    AttrRegistry::DESCRIPTION => 'Событие временно не активно'
                ]
            ]);

        $this->addForeignKey(
            'FGK-status_id-event',
            TableRegistry::NAME_EVENT,
            AttrRegistry::STATUS_ID,
            TableRegistry::NAME_EVENT_STATUS,
            AttrRegistry::ID
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-status_id-event', TableRegistry::NAME_EVENT);
        $this->dropTable(TableRegistry::NAME_EVENT_STATUS);
    }
}
