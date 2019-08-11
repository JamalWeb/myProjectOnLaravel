<?php

use yii\db\Migration;

/**
 * Class m190803_205321_alter_table_user
 */
class m190803_205321_alter_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%user}}', 'user_type_id', 'type_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%user}}', 'type_id', 'user_type_id');
    }
}
