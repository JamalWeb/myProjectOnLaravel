<?php
require_once Yii::getAlias('@yii/i18n/migrations/m150207_210500_i18n_init.php');

use yii\db\Migration;

/**
 * Class m190721_221008_add_transalte
 */
class m190721_221008_add_transalte extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        (new m150207_210500_i18n_init())->up();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        (new m150207_210500_i18n_init())->down();
    }
}
