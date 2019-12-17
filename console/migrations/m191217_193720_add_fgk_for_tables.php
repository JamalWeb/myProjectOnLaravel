<?php

use common\components\registry\AttributeRegistry;
use common\components\registry\TableRegistry;
use yii\db\Migration;

/**
 * Class m191217_193720_add_fgk_for_tables
 */
class m191217_193720_add_fgk_for_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'FGK-user_id-user_children',
            TableRegistry::TABLE_NAME_USER_CHILDREN,
            AttributeRegistry::USER_ID,
            TableRegistry::TABLE_NAME_USER,
            AttributeRegistry::ID,
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'FGK-gender_id-',
            '',
            '',
            '',
            '',
            '',
            ''
        );
//
//        $this->addForeignKey(
//            '',
//            '',
//            '',
//            '',
//            '',
//            '',
//            ''
//        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191217_193720_add_fgk_for_tables cannot be reverted.\n";

        return false;
    }
}
