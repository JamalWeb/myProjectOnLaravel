<?php

use common\components\registry\Constants;
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
        $this->createTable(Constants::TABLE_NAME_CITY, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор города'),

            'name' => $this->string()
                ->notNull()
                ->comment('Наименование города')
        ]);

        $this->batchInsert(Constants::TABLE_NAME_CITY, ['name'], [
            ['name' => 'Moscow'],
            ['name' => 'San Francisco'],
            ['name' => 'London']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Constants::TABLE_NAME_CITY);
    }
}
