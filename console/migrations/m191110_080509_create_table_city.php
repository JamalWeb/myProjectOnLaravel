<?php

use common\components\registry\AttributeRegistry;
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
        $this->createTable(TableRegistry::TABLE_NAME_CITY, [
            AttributeRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор города'),

            AttributeRegistry::NAME => $this->string()
                ->notNull()
                ->comment('Наименование города')
        ]);

        $this->batchInsert(
            TableRegistry::TABLE_NAME_CITY,
            [AttributeRegistry::NAME],
            [
                [AttributeRegistry::NAME => 'Moscow'],
                [AttributeRegistry::NAME => 'San Francisco'],
                [AttributeRegistry::NAME => 'London']
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::TABLE_NAME_CITY);
    }
}
