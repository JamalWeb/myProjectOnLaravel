<?php

use common\components\registry\AttributeRegistry;
use common\components\registry\TableRegistry;
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

        $this->createTable(TableRegistry::TABLE_NAME_USER_TOKEN, [
            AttributeRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор токена'),

            AttributeRegistry::USER_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор пользователя'),

            AttributeRegistry::TYPE_ID => $this->integer()
                ->notNull()
                ->comment('Тип токена'),

            AttributeRegistry::ACCESS_TOKEN => $this->string()
                ->notNull()
                ->comment('Токен доступа'),

            AttributeRegistry::DATA => $this->text()
                ->comment('Временное хранение данных'),

            AttributeRegistry::EXPIRED_AT => $this->timestamp()
                ->comment('Срок действия'),

            AttributeRegistry::CREATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата создания'),

            AttributeRegistry::UPDATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата обновления')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::TABLE_NAME_USER_TOKEN);
    }
}
