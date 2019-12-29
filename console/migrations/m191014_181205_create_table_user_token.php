<?php

use common\components\registry\AttrRegistry;
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

        $this->createTable(TableRegistry::NAME_USER_TOKEN, [
            AttrRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор токена'),

            AttrRegistry::USER_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор пользователя'),

            AttrRegistry::TYPE_ID => $this->integer()
                ->notNull()
                ->comment('Тип токена'),

            AttrRegistry::ACCESS_TOKEN => $this->string()
                ->notNull()
                ->comment('Токен доступа'),

            AttrRegistry::DATA => $this->text()
                ->comment('Временное хранение данных'),

            AttrRegistry::EXPIRED_AT => $this->timestamp()
                ->comment('Срок действия'),

            AttrRegistry::CREATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата создания'),

            AttrRegistry::UPDATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата обновления')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::NAME_USER_TOKEN);
    }
}
