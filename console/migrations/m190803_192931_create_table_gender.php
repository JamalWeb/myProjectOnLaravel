<?php

use yii\db\Migration;

/**
 * Class m190803_192931_create_table_gender
 */
class m190803_192931_create_table_gender extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%gender}}', [
            'id'   => $this->primaryKey(),
            'name' => $this->string()->notNull()
        ]);

        $this->batchInsert('{{%gender}}', ['name'], [
            ['name' => 'Male'],
            ['name' => 'Female'],
        ]);

        $this->renameColumn('{{%children}}', 'gender', 'gender_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%children}}', 'gender_id', 'gender');
        $this->dropTable('{{%gender}}');
    }
}
