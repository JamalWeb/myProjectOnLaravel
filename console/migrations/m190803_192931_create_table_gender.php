<?php

use common\components\registry\AttributeRegistry;
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
        $this->createTable(TableRegistry::TABLE_NAME_USER_GENDER, [
            AttributeRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор пола'),

            AttributeRegistry::NAME => $this->string()
                ->notNull()
                ->comment('Наименование пола')
        ]);

        $this->batchInsert(
            TableRegistry::TABLE_NAME_USER_GENDER,
            [AttributeRegistry::NAME],
            [
                [AttributeRegistry::NAME => 'Male'],
                [AttributeRegistry::NAME => 'Female'],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::TABLE_NAME_USER_GENDER);
    }
}
