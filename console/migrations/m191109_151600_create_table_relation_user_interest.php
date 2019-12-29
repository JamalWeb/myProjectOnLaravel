<?php

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use yii\db\Migration;

/**
 * Class m191109_151600_create_table_relation_user_interest
 */
class m191109_151600_create_table_relation_user_interest extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            RgTable::NAME_RELATION_USER_INTEREST,
            [
                RgAttribute::ID => $this->primaryKey()
                    ->comment('Идентификатор связи пользователя с его интересами'),

                RgAttribute::USER_ID => $this->integer()
                    ->notNull()
                    ->comment('Идентификатор пользователя'),

                RgAttribute::INTEREST_CATEGORY_ID => $this->integer()
                    ->notNull()
                    ->comment('Идентификатор интереса'),

                RgAttribute::CREATED_AT => $this->timestamp()
                    ->comment('Дата создания'),

                RgAttribute::UPDATED_AT => $this->timestamp()
                    ->comment('Дата обновления')
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(RgTable::NAME_RELATION_USER_INTEREST);
    }
}
