<?php

use yii\db\Migration;

/**
 * Class m191208_130426_create_table_event_carrying_date
 */
class m191208_130426_create_table_event_carrying_date extends Migration
{
    const TABLE_NAME = '{{%event_carrying_date}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор даты проведения события'),

            'event_id' => $this->integer()
                ->notNull()
                ->comment('Идентификатор события'),

            'date' => $this->timestamp()
                ->notNull()
                ->comment('Дата проведения'),

            'duration' => $this->integer()
                ->comment('Продолжительность')
        ]);

        $this->addForeignKey(
            'FGK-event_id-event_carrying_date',
            self::TABLE_NAME,
            'event_id',
            '{{%event}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-event_id-event_carrying_date', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
