<?php

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
use yii\db\Migration;

/**
 * Class m191110_080509_create_table_city
 */
class m191110_080509_create_table_city extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(TableRegistry::NAME_CITY, [
            AttrRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор города'),

            AttrRegistry::NAME => $this->string()
                ->notNull()
                ->comment('Наименование города')
        ]);

        $this->batchInsert(
            TableRegistry::NAME_CITY,
            [AttrRegistry::NAME],
            [
                [AttrRegistry::NAME => 'Moscow'],
                [AttrRegistry::NAME => 'San Francisco'],
                [AttrRegistry::NAME => 'London']
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::NAME_CITY);
    }
}
