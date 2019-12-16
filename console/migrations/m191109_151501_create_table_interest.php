<?php

use common\components\registry\Constants;
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
        $this->createTable(Constants::TABLE_NAME_INTEREST_CATEGORY, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор интереса'),

            'name' => $this->string()
                ->notNull()
                ->comment('Наименование интереса'),

            'img' => $this->string()
                ->notNull()
                ->comment('Наименование картинки'),
        ]);

        $this->batchInsert(Constants::TABLE_NAME_INTEREST_CATEGORY, ['name', 'img'], [
            [
                'name' => 'Entertainment',
                'img'  => 'entertainment.png'
            ],
            [
                'name' => 'Art',
                'img'  => 'art.png'
            ],
            [
                'name' => 'Sport',
                'img'  => 'sport.png'
            ],
            [
                'name' => 'Music',
                'img'  => 'music.png'
            ],
            [
                'name' => 'Education',
                'img'  => 'education.png'
            ],
            [
                'name' => 'Talks',
                'img'  => 'talks.png'
            ],
            [
                'name' => 'Food',
                'img'  => 'food.png'
            ],
            [
                'name' => 'Shopping',
                'img'  => 'shopping.png'
            ],
            [
                'name' => 'Strolls',
                'img'  => 'strolls.png'
            ],
            [
                'name' => 'Travel',
                'img'  => 'travel.png'
            ],
            [
                'name' => 'Health',
                'img'  => 'health.png'
            ],
            [
                'name' => 'Beauty',
                'img'  => 'beauty.png'
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Constants::TABLE_NAME_INTEREST_CATEGORY);
    }
}
