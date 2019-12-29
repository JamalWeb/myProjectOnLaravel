<?php

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
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

        $this->createTable(
            RgTable::NAME_USER_TOKEN,
            [
                RgAttribute::ID => $this->primaryKey()
                    ->comment('Идентификатор токена'),

                RgAttribute::USER_ID => $this->integer()
                    ->notNull()
                    ->comment('Идентификатор пользователя'),

                RgAttribute::TYPE_ID => $this->integer()
                    ->notNull()
                    ->comment('Тип токена'),

                RgAttribute::ACCESS_TOKEN => $this->string()
                    ->notNull()
                    ->comment('Токен доступа'),

                RgAttribute::DATA => $this->text()
                    ->comment('Временное хранение данных'),

                RgAttribute::EXPIRED_AT => $this->timestamp()
                    ->comment('Срок действия'),

                RgAttribute::CREATED_AT => $this->timestamp()
                    ->defaultValue($defaultDate)
                    ->comment('Дата создания'),

                RgAttribute::UPDATED_AT => $this->timestamp()
                    ->defaultValue($defaultDate)
                    ->comment('Дата обновления')
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(RgTable::NAME_USER_TOKEN);
    }
}
