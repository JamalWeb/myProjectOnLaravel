<?php

use common\components\registry\Constants;
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
        $this->createTable(Constants::TABLE_NAME_EVENT_STATUS, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор статуса события'),

            'name' => $this->string()
                ->comment('Наименование статуса события'),

            'desc' => $this->string()
                ->comment('Описание статуса события'),
        ]);

        $this->batchInsert(Constants::TABLE_NAME_EVENT_STATUS, ['name', 'desc'], [
            [
                'name' => 'Новое',
                'desc' => 'Новое событие'
            ],
            [
                'name' => 'Завершено',
                'desc' => 'Событие было завершено'
            ],
            [
                'name' => 'Отменено',
                'desc' => 'Событие было отменено'
            ],
            [
                'name' => 'Не активно',
                'desc' => 'Событие временно не активно'
            ]
        ]);

        $this->addForeignKey(
            'FGK-status_id-event',
            Constants::TABLE_NAME_EVENT,
            'status_id',
            Constants::TABLE_NAME_EVENT_STATUS,
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-status_id-event', Constants::TABLE_NAME_EVENT);
        $this->dropTable(Constants::TABLE_NAME_EVENT_STATUS);
    }
}
