<?php

use yii\db\Migration;

/**
 * Class m190803_192524_alter_table_profile
 */
class m190803_192524_alter_table_profile extends Migration
{
    public $tableName = '{{%profile}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn($this->tableName, 'full_name');
        $this->dropColumn($this->tableName, 'short_lang');
        $this->renameColumn($this->tableName, 'category_profile_id', 'category_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190803_192524_alter_table_profile cannot be reverted.\n";

        return false;
    }
}
