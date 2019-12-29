<?php

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use yii\db\Migration;

/**
 * Class m191109_151501_create_table_interest
 */
class m191109_151501_create_table_interest extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            RgTable::NAME_INTEREST_CATEGORY,
            [
                RgAttribute::ID => $this->primaryKey()
                    ->comment('Идентификатор интереса'),

                RgAttribute::NAME => $this->string()
                    ->notNull()
                    ->comment('Наименование интереса'),

                RgAttribute::IMG => $this->string()
                    ->notNull()
                    ->comment('Наименование картинки'),
            ]
        );

        $this->batchInsert(
            RgTable::NAME_INTEREST_CATEGORY,
            [
                RgAttribute::NAME,
                RgAttribute::IMG
            ],
            [
                [
                    RgAttribute::NAME => 'Entertainment',
                    RgAttribute::IMG  => 'entertainment.png'
                ],
                [
                    RgAttribute::NAME => 'Art',
                    RgAttribute::IMG  => 'art.png'
                ],
                [
                    RgAttribute::NAME => 'Sport',
                    RgAttribute::IMG  => 'sport.png'
                ],
                [
                    RgAttribute::NAME => 'Music',
                    RgAttribute::IMG  => 'music.png'
                ],
                [
                    RgAttribute::NAME => 'Education',
                    RgAttribute::IMG  => 'education.png'
                ],
                [
                    RgAttribute::NAME => 'Talks',
                    RgAttribute::IMG  => 'talks.png'
                ],
                [
                    RgAttribute::NAME => 'Food',
                    RgAttribute::IMG  => 'food.png'
                ],
                [
                    RgAttribute::NAME => 'Shopping',
                    RgAttribute::IMG  => 'shopping.png'
                ],
                [
                    RgAttribute::NAME => 'Strolls',
                    RgAttribute::IMG  => 'strolls.png'
                ],
                [
                    RgAttribute::NAME => 'Travel',
                    RgAttribute::IMG  => 'travel.png'
                ],
                [
                    RgAttribute::NAME => 'Health',
                    RgAttribute::IMG  => 'health.png'
                ],
                [
                    RgAttribute::NAME => 'Beauty',
                    RgAttribute::IMG  => 'beauty.png'
                ]
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(RgTable::NAME_INTEREST_CATEGORY);
    }
}
