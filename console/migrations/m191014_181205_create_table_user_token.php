<?php

use common\components\registry\Constants;
use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m191014_181205_create_table_user_token
 */
class m191014_181205_create_table_user_token extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $defaultDate = new Expression('CURRENT_TIMESTAMP');

        $this->createTable(Constants::TABLE_NAME_USER_TOKEN, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор токена'),

            'user_id' => $this->integer()
                ->notNull()
                ->comment('Идентификатор пользователя'),

            'type' => $this->integer()
                ->notNull()
                ->comment('Тип токена'),

            'access_token' => $this->string()
                ->notNull()
                ->comment('Токен доступа'),

            'data' => $this->text()
                ->comment('Временное хранение данных'),

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
        $this->dropTable(Constants::TABLE_NAME_USER_TOKEN);
    }
}
