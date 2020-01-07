<?php

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
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
        $this->createTable(
            RgTable::NAME_EVENT_CARRYING_DATE,
            [
                RgAttribute::ID => $this->primaryKey()
                    ->comment('Идентификатор даты проведения события'),

                RgAttribute::EVENT_ID => $this->integer()
                    ->notNull()
                    ->comment('Идентификатор события'),

                RgAttribute::DATE => $this->timestamp()
                    ->notNull()
                    ->comment('Дата проведения'),

                RgAttribute::DURATION => $this->time()
                    ->comment('Продолжительность')
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(RgTable::NAME_EVENT_CARRYING_DATE);
    }
}
