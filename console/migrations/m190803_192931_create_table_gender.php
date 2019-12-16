<?php

use common\components\registry\Constants;
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
        $this->createTable(Constants::TABLE_NAME_USER_GENDER, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор пола'),

            'name' => $this->string()
                ->notNull()
                ->comment('Наименование пола')
        ]);

        $this->batchInsert(Constants::TABLE_NAME_USER_GENDER, ['name'], [
            ['name' => 'Male'],
            ['name' => 'Female'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Constants::TABLE_NAME_USER_GENDER);
    }
}
