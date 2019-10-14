<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m191014_174852_create_table_user_role
 */
class m191014_174852_create_table_user_role extends Migration
{
    const TABLE_NAME = '{{%user_role}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $defaultDate = new Expression('CURRENT_TIMESTAMP');

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор роли'),

            'name' => $this->string()
                ->notNull()
                ->comment('Наименование роли'),

            'desc' => $this->string()
                ->notNull()
                ->comment('Описание роли'),

            'created_at' => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата создания'),

            'updated_at' => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата обновления')
        ]);

        $this->batchInsert(self::TABLE_NAME, ['name', 'desc'], [
            [
                'Admin',
                'Администратор',
            ],
            [
                'User',
                'Обычный пользователь'
            ],
            [
                'Business',
                'Бизнес пользователь'
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
