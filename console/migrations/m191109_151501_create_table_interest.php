<?php

use common\components\registry\AttributeRegistry;
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
        $this->createTable(TableRegistry::TABLE_NAME_INTEREST_CATEGORY, [
            AttributeRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор интереса'),

            AttributeRegistry::NAME => $this->string()
                ->notNull()
                ->comment('Наименование интереса'),

            AttributeRegistry::IMG => $this->string()
                ->notNull()
                ->comment('Наименование картинки'),
        ]);

        $this->batchInsert(
            TableRegistry::TABLE_NAME_INTEREST_CATEGORY,
            [
                AttributeRegistry::NAME,
                AttributeRegistry::IMG
            ],
            [
                [
                    AttributeRegistry::NAME => 'Entertainment',
                    AttributeRegistry::IMG  => 'entertainment.png'
                ],
                [
                    AttributeRegistry::NAME => 'Art',
                    AttributeRegistry::IMG  => 'art.png'
                ],
                [
                    AttributeRegistry::NAME => 'Sport',
                    AttributeRegistry::IMG  => 'sport.png'
                ],
                [
                    AttributeRegistry::NAME => 'Music',
                    AttributeRegistry::IMG  => 'music.png'
                ],
                [
                    AttributeRegistry::NAME => 'Education',
                    AttributeRegistry::IMG  => 'education.png'
                ],
                [
                    AttributeRegistry::NAME => 'Talks',
                    AttributeRegistry::IMG  => 'talks.png'
                ],
                [
                    AttributeRegistry::NAME => 'Food',
                    AttributeRegistry::IMG  => 'food.png'
                ],
                [
                    AttributeRegistry::NAME => 'Shopping',
                    AttributeRegistry::IMG  => 'shopping.png'
                ],
                [
                    AttributeRegistry::NAME => 'Strolls',
                    AttributeRegistry::IMG  => 'strolls.png'
                ],
                [
                    AttributeRegistry::NAME => 'Travel',
                    AttributeRegistry::IMG  => 'travel.png'
                ],
                [
                    AttributeRegistry::NAME => 'Health',
                    AttributeRegistry::IMG  => 'health.png'
                ],
                [
                    AttributeRegistry::NAME => 'Beauty',
                    AttributeRegistry::IMG  => 'beauty.png'
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::TABLE_NAME_INTEREST_CATEGORY);
    }
}
