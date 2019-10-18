<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m191014_181205_create_table_user_token
 */
class m191014_181205_create_table_user_token extends Migration
{
    const TABLE_NAME = '{{%user_token}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $defaultDate = new Expression('CURRENT_TIMESTAMP');

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор токена'),

            'user_id' => $this->integer()
                ->notNull()
                ->comment('Идентификатор пользователя'),

            'type' => $this->integer()
                ->notNull()
                ->comment('Тип токена'),

            'assess_token' => $this->string()
                ->notNull()
                ->comment('Токен доступа'),

            'expired_at' => $this->timestamp()
                ->comment('Срок действия'),

            'created_at' => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата создания'),

            'updated_at' => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата обновления')
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
