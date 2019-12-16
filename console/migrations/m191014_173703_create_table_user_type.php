<?php

use common\components\registry\Constants;
use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m191014_173703_create_table_user_type
 */
class m191014_173703_create_table_user_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $defaultDate = new Expression('CURRENT_TIMESTAMP');

        $this->createTable(Constants::TABLE_NAME_USER_TYPE, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор типа'),

            'name' => $this->string()
                ->notNull()
                ->comment('Наименование'),

            'desc' => $this->string()
                ->comment('Описание'),

            'created_at' => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата создания'),

            'updated_at' => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата обновления')
        ]);

        $this->batchInsert(Constants::TABLE_NAME_USER_TYPE, ['name', 'desc'], [
            [
                'name' => 'System',
                'desc' => 'Системный пользователь'
            ],
            [
                'name' => 'User',
                'desc' => 'Обычный пользователь'
            ],
            [
                'name' => 'Business',
                'desc' => 'Бизнес пользователь'
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Constants::TABLE_NAME_USER_TYPE);
    }
}
