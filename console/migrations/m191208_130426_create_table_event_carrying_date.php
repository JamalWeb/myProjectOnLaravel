<?php

use common\components\registry\Constants;
use yii\db\Migration;

/**
 * Class m191208_130426_create_table_event_carrying_date
 */
class m191208_130426_create_table_event_carrying_date extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Constants::TABLE_NAME_EVENT_CARRYING_DATE, [
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
            Constants::TABLE_NAME_EVENT_CARRYING_DATE,
            'event_id',
            Constants::TABLE_NAME_EVENT,
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-event_id-event_carrying_date', Constants::TABLE_NAME_EVENT_CARRYING_DATE);
        $this->dropTable(Constants::TABLE_NAME_EVENT_CARRYING_DATE);
    }
}
