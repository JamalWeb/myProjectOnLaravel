<?php

use common\components\registry\AttributeRegistry;
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
        $this->createTable(TableRegistry::TABLE_NAME_EVENT_STATUS, [
            AttributeRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор статуса события'),

            AttributeRegistry::NAME => $this->string()
                ->comment('Наименование статуса события'),

            AttributeRegistry::DESCRIPTION => $this->string()
                ->comment('Описание статуса события'),
        ]);

        $this->batchInsert(
            TableRegistry::TABLE_NAME_EVENT_STATUS,
            [
                AttributeRegistry::NAME,
                AttributeRegistry::DESCRIPTION
            ],
            [
                [
                    AttributeRegistry::NAME        => 'Новое',
                    AttributeRegistry::DESCRIPTION => 'Новое событие'
                ],
                [
                    AttributeRegistry::NAME        => 'Завершено',
                    AttributeRegistry::DESCRIPTION => 'Событие было завершено'
                ],
                [
                    AttributeRegistry::NAME        => 'Отменено',
                    AttributeRegistry::DESCRIPTION => 'Событие было отменено'
                ],
                [
                    AttributeRegistry::NAME        => 'Не активно',
                    AttributeRegistry::DESCRIPTION => 'Событие временно не активно'
                ]
            ]);

        $this->addForeignKey(
            'FGK-status_id-event',
            TableRegistry::TABLE_NAME_EVENT,
            AttributeRegistry::STATUS_ID,
            TableRegistry::TABLE_NAME_EVENT_STATUS,
            AttributeRegistry::ID
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-status_id-event', TableRegistry::TABLE_NAME_EVENT);
        $this->dropTable(TableRegistry::TABLE_NAME_EVENT_STATUS);
    }
}
