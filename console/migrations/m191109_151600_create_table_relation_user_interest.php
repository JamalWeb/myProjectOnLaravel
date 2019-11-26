<?php

use yii\db\Migration;

/**
 * Class m191109_151600_create_table_relation_user_interest
 */
class m191109_151600_create_table_relation_user_interest extends Migration
{
    const TABLE_NAME_RELATION_USER_INTEREST = '{{%relation_user_interest}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME_RELATION_USER_INTEREST, [
            'id' => $this->primaryKey()
                ->comment('Идентификатор связи пользователя с его интересами'),

            'user_id' => $this->integer()
                ->notNull()
                ->comment('Идентификатор пользователя'),

            'interest_category_id' => $this->integer()
                ->notNull()
                ->comment('Идентификатор интереса'),

            'created_at' => $this->timestamp()
                ->comment('Дата создания'),

            'updated_at' => $this->timestamp()
                ->comment('Дата обновления')
        ]);

        $this->addForeignKey(
            'FGK-user_id-relation_user_interest',
            self::TABLE_NAME_RELATION_USER_INTEREST,
            'user_id',
            '{{%user}}',
            'id'
        );

        $this->addForeignKey(
            'FGK-interest_category_id-relation_user_interest',
            self::TABLE_NAME_RELATION_USER_INTEREST,
            'interest_category_id',
            '{{%interest_category}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'FGK-interest_category_id-relation_user_interest',
            self::TABLE_NAME_RELATION_USER_INTEREST
        );

        $this->dropForeignKey(
            'FGK-user_id-relation_user_interest',
            self::TABLE_NAME_RELATION_USER_INTEREST
        );

        $this->dropTable(self::TABLE_NAME_RELATION_USER_INTEREST);
    }
}
