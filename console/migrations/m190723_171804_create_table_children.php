<?php

use common\components\registry\Constants;
use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m190723_171804_create_table_children
 */
class m190723_171804_create_table_children extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $defaultDate = new Expression('CURRENT_TIMESTAMP');

        $this->createTable(Constants::TABLE_NAME_USER_CHILDREN, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор ребенка пользователя'),

            'user_id' => $this->integer()
                ->notNull()
                ->comment('Идентификатор пользователя'),

            'age' => $this->integer()
                ->notNull()
                ->comment('Возраст'),

            'gender_id' => $this->integer()
                ->notNull()
                ->comment('Идентификатор пола'),

            'created_at' => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата создания'),

            'updated_at' => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата обновления'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Constants::TABLE_NAME_USER_CHILDREN);
    }
}
