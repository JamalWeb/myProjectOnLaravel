<?php

use yii\db\Migration;

/**
 * Class m190803_192931_create_table_gender
 */
class m190803_192931_create_table_gender extends Migration
{
    const TABLE_NAME = '{{%user_gender}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор пола'),

            'name' => $this->string()
                ->notNull()
                ->comment('Наименование пола')
        ]);

        $this->batchInsert(self::TABLE_NAME, ['name'], [
            ['name' => 'Male'],
            ['name' => 'Female'],
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
