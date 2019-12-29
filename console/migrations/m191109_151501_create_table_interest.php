<?php

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
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
        $this->createTable(TableRegistry::NAME_INTEREST_CATEGORY, [
            AttrRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор интереса'),

            AttrRegistry::NAME => $this->string()
                ->notNull()
                ->comment('Наименование интереса'),

            AttrRegistry::IMG => $this->string()
                ->notNull()
                ->comment('Наименование картинки'),
        ]);

        $this->batchInsert(
            TableRegistry::NAME_INTEREST_CATEGORY,
            [
                AttrRegistry::NAME,
                AttrRegistry::IMG
            ],
            [
                [
                    AttrRegistry::NAME => 'Entertainment',
                    AttrRegistry::IMG  => 'entertainment.png'
                ],
                [
                    AttrRegistry::NAME => 'Art',
                    AttrRegistry::IMG  => 'art.png'
                ],
                [
                    AttrRegistry::NAME => 'Sport',
                    AttrRegistry::IMG  => 'sport.png'
                ],
                [
                    AttrRegistry::NAME => 'Music',
                    AttrRegistry::IMG  => 'music.png'
                ],
                [
                    AttrRegistry::NAME => 'Education',
                    AttrRegistry::IMG  => 'education.png'
                ],
                [
                    AttrRegistry::NAME => 'Talks',
                    AttrRegistry::IMG  => 'talks.png'
                ],
                [
                    AttrRegistry::NAME => 'Food',
                    AttrRegistry::IMG  => 'food.png'
                ],
                [
                    AttrRegistry::NAME => 'Shopping',
                    AttrRegistry::IMG  => 'shopping.png'
                ],
                [
                    AttrRegistry::NAME => 'Strolls',
                    AttrRegistry::IMG  => 'strolls.png'
                ],
                [
                    AttrRegistry::NAME => 'Travel',
                    AttrRegistry::IMG  => 'travel.png'
                ],
                [
                    AttrRegistry::NAME => 'Health',
                    AttrRegistry::IMG  => 'health.png'
                ],
                [
                    AttrRegistry::NAME => 'Beauty',
                    AttrRegistry::IMG  => 'beauty.png'
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::NAME_INTEREST_CATEGORY);
    }
}
