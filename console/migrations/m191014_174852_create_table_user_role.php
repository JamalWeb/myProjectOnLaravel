<?php

use common\components\registry\Constants;
use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m191014_174852_create_table_user_role
 */
class m191014_174852_create_table_user_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $defaultDate = new Expression('CURRENT_TIMESTAMP');

        $this->createTable(Constants::TABLE_NAME_USER_ROLE, [
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

        $this->batchInsert(Constants::TABLE_NAME_USER_ROLE, ['name', 'desc'], [
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
        $this->dropTable(Constants::TABLE_NAME_USER_ROLE);
    }
}
