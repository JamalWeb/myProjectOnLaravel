<?php

use yii\db\Migration;

/**
 * Class m190803_194907_alter_table_children
 */
class m190803_194907_alter_table_children extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE main.children ALTER COLUMN gender_id TYPE integer USING (gender_id::integer)');
        $this->addColumn('{{%profile}}', 'gender_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('ALTER TABLE main.children ALTER COLUMN gender_id TYPE varchar USING (gender_id::varchar)');
        $this->dropColumn('{{%profile}}', 'gender_id');
    }
}
