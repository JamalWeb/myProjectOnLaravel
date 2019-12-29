<?php

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
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
        $this->createTable(
            RgTable::NAME_USER_GENDER,
            [
                RgAttribute::ID => $this->primaryKey()
                    ->comment('Идентификатор пола'),

                RgAttribute::NAME => $this->string()
                    ->notNull()
                    ->comment('Наименование пола')
            ]
        );

        $this->batchInsert(
            RgTable::NAME_USER_GENDER,
            [
                RgAttribute::NAME
            ],
            [
                [
                    RgAttribute::NAME => 'Male'
                ],
                [
                    RgAttribute::NAME => 'Female'
                ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(RgTable::NAME_USER_GENDER);
    }
}
