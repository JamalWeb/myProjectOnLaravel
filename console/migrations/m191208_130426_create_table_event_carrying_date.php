<?php

use common\components\registry\AttributeRegistry;
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
        $this->createTable(TableRegistry::TABLE_NAME_EVENT_CARRYING_DATE, [
            AttributeRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор даты проведения события'),

            AttributeRegistry::EVENT_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор события'),

            AttributeRegistry::DATE => $this->timestamp()
                ->notNull()
                ->comment('Дата проведения'),

            AttributeRegistry::DURATION => $this->integer()
                ->comment('Продолжительность')
        ]);

        $this->addForeignKey(
            'FGK-event_id-event_carrying_date',
            TableRegistry::TABLE_NAME_EVENT_CARRYING_DATE,
            AttributeRegistry::EVENT_ID,
            TableRegistry::TABLE_NAME_EVENT,
            AttributeRegistry::ID
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-event_id-event_carrying_date', TableRegistry::TABLE_NAME_EVENT_CARRYING_DATE);
        $this->dropTable(TableRegistry::TABLE_NAME_EVENT_CARRYING_DATE);
    }
}
