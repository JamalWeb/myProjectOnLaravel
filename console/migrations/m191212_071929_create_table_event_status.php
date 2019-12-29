<?php

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
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
        $this->createTable(
            RgTable::NAME_EVENT_STATUS,
            [
                RgAttribute::ID => $this->primaryKey()
                    ->comment('Идентификатор статуса события'),

                RgAttribute::NAME => $this->string()
                    ->comment('Наименование статуса события'),

                RgAttribute::DESCRIPTION => $this->string()
                    ->comment('Описание статуса события'),
            ]
        );

        $this->batchInsert(
            RgTable::NAME_EVENT_STATUS,
            [
                RgAttribute::NAME,
                RgAttribute::DESCRIPTION
            ],
            [
                [
                    RgAttribute::NAME        => 'Новое',
                    RgAttribute::DESCRIPTION => 'Новое событие'
                ],
                [
                    RgAttribute::NAME        => 'Завершено',
                    RgAttribute::DESCRIPTION => 'Событие было завершено'
                ],
                [
                    RgAttribute::NAME        => 'Отменено',
                    RgAttribute::DESCRIPTION => 'Событие было отменено'
                ],
                [
                    RgAttribute::NAME        => 'Не активно',
                    RgAttribute::DESCRIPTION => 'Событие временно не активно'
                ]
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(RgTable::NAME_EVENT_STATUS);
    }
}
