<?php

use yii\db\Migration;

/**
 * Class m191110_080509_create_table_city
 */
class m191110_080509_create_table_city extends Migration
{
    const TABLE_NAME = '{{%city}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор города'),

            'name' => $this->string()
                ->notNull()
                ->comment('Наименование города')
        ]);

        $this->batchInsert(self::TABLE_NAME, ['name'], [
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
        $this->dropTable(self::TABLE_NAME);
    }
}
