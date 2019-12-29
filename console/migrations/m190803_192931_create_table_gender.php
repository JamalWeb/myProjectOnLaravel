<?php

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
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
        $this->createTable(TableRegistry::NAME_USER_GENDER, [
            AttrRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор пола'),

            AttrRegistry::NAME => $this->string()
                ->notNull()
                ->comment('Наименование пола')
        ]);

        $this->batchInsert(
            TableRegistry::NAME_USER_GENDER,
            [AttrRegistry::NAME],
            [
                [AttrRegistry::NAME => 'Male'],
                [AttrRegistry::NAME => 'Female'],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::NAME_USER_GENDER);
    }
}
