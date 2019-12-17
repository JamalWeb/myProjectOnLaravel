<?php

use common\components\registry\AttributeRegistry;
use common\components\registry\TableRegistry;
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
        $this->createTable(TableRegistry::TABLE_NAME_RELATION_USER_INTEREST, [
            AttributeRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор связи пользователя с его интересами'),

            AttributeRegistry::USER_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор пользователя'),

            AttributeRegistry::INTEREST_CATEGORY_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор интереса'),

            AttributeRegistry::CREATED_AT => $this->timestamp()
                ->comment('Дата создания'),

            AttributeRegistry::UPDATED_AT => $this->timestamp()
                ->comment('Дата обновления')
        ]);

        $this->addForeignKey(
            'FGK-user_id-relation_user_interest',
            TableRegistry::TABLE_NAME_RELATION_USER_INTEREST,
            AttributeRegistry::USER_ID,
            TableRegistry::TABLE_NAME_USER,
            AttributeRegistry::ID
        );

        $this->addForeignKey(
            'FGK-interest_category_id-relation_user_interest',
            TableRegistry::TABLE_NAME_RELATION_USER_INTEREST,
            AttributeRegistry::INTEREST_CATEGORY_ID,
            TableRegistry::TABLE_NAME_INTEREST_CATEGORY,
            AttributeRegistry::ID
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'FGK-interest_category_id-relation_user_interest',
            TableRegistry::TABLE_NAME_RELATION_USER_INTEREST
        );

        $this->dropForeignKey(
            'FGK-user_id-relation_user_interest',
            TableRegistry::TABLE_NAME_RELATION_USER_INTEREST
        );

        $this->dropTable(TableRegistry::TABLE_NAME_RELATION_USER_INTEREST);
    }
}
