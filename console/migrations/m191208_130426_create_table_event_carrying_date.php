<?php

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
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
        $this->createTable(TableRegistry::NAME_EVENT_CARRYING_DATE, [
            AttrRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор даты проведения события'),

            AttrRegistry::EVENT_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор события'),

            AttrRegistry::DATE => $this->timestamp()
                ->notNull()
                ->comment('Дата проведения'),

            AttrRegistry::DURATION => $this->integer()
                ->comment('Продолжительность')
        ]);

        $this->addForeignKey(
            'FGK-event_id-event_carrying_date',
            TableRegistry::NAME_EVENT_CARRYING_DATE,
            AttrRegistry::EVENT_ID,
            TableRegistry::NAME_EVENT,
            AttrRegistry::ID
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-event_id-event_carrying_date', TableRegistry::NAME_EVENT_CARRYING_DATE);
        $this->dropTable(TableRegistry::NAME_EVENT_CARRYING_DATE);
    }
}
