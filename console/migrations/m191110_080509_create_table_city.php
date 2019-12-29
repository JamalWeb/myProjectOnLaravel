<?php

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use yii\db\Migration;

/**
 * Class m191110_080509_create_table_city
 */
class m191110_080509_create_table_city extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            RgTable::NAME_CITY,
            [
                RgAttribute::ID => $this->primaryKey()
                    ->comment('Идентификатор города'),

                RgAttribute::NAME => $this->string()
                    ->notNull()
                    ->comment('Наименование города')
            ]
        );

        $this->batchInsert(
            RgTable::NAME_CITY,
            [
                RgAttribute::NAME
            ],
            [
                [
                    RgAttribute::NAME => 'Moscow'
                ],
                [
                    RgAttribute::NAME => 'San Francisco'
                ],
                [
                    RgAttribute::NAME => 'London'
                ]
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(RgTable::NAME_CITY);
    }
}
