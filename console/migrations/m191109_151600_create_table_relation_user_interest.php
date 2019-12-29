<?php

use common\components\registry\AttrRegistry;
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
        $this->createTable(TableRegistry::NAME_RELATION_USER_INTEREST, [
            AttrRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор связи пользователя с его интересами'),

            AttrRegistry::USER_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор пользователя'),

            AttrRegistry::INTEREST_CATEGORY_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор интереса'),

            AttrRegistry::CREATED_AT => $this->timestamp()
                ->comment('Дата создания'),

            AttrRegistry::UPDATED_AT => $this->timestamp()
                ->comment('Дата обновления')
        ]);

        $this->addForeignKey(
            'FGK-user_id-relation_user_interest',
            TableRegistry::NAME_RELATION_USER_INTEREST,
            AttrRegistry::USER_ID,
            TableRegistry::NAME_USER,
            AttrRegistry::ID
        );

        $this->addForeignKey(
            'FGK-interest_category_id-relation_user_interest',
            TableRegistry::NAME_RELATION_USER_INTEREST,
            AttrRegistry::INTEREST_CATEGORY_ID,
            TableRegistry::NAME_INTEREST_CATEGORY,
            AttrRegistry::ID
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'FGK-interest_category_id-relation_user_interest',
            TableRegistry::NAME_RELATION_USER_INTEREST
        );

        $this->dropForeignKey(
            'FGK-user_id-relation_user_interest',
            TableRegistry::NAME_RELATION_USER_INTEREST
        );

        $this->dropTable(TableRegistry::NAME_RELATION_USER_INTEREST);
    }
}
