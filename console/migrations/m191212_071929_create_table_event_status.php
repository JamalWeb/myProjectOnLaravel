<?php

use yii\db\Migration;

/**
 * Class m191212_071929_create_table_event_status
 */
class m191212_071929_create_table_event_status extends Migration
{
    const TABLE_NAME = '{{%event_status}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор статуса события'),

            'name' => $this->string()
                ->comment('Наименование статуса события'),

            'desc' => $this->string()
                ->comment('Описание статуса события'),
        ]);

        $this->batchInsert(self::TABLE_NAME, ['name', 'desc'], [
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
            '{{%event}}',
            'status_id',
            self::TABLE_NAME,
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-status_id-event', '{{%event}}');
        $this->dropTable(self::TABLE_NAME);
    }
}
