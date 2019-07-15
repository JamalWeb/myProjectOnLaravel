<?php
require_once Yii::getAlias('@vendor/amnah/yii2-user/migrations/m150214_044831_init_user.php');

use yii\db\Migration;

/**
 * Class m190715_174609_alter_tables
 */
class m190715_174609_alter_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%user_type}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%category_profile}}');
        $this->dropTable('{{%user_profile}}');
        (new m150214_044831_init_user())->up();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        (new m150214_044831_init_user())->down();
    }
}
