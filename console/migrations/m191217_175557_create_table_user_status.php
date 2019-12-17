<?php

use common\components\registry\AttributeRegistry;
use common\components\registry\TableRegistry;
use yii\db\Migration;

/**
 * Class m191217_175557_create_table_user_status
 */
class m191217_175557_create_table_user_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(TableRegistry::TABLE_NAME_USER_STATUS, [
            AttributeRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор статуса пользователя'),

            AttributeRegistry::NAME => $this->string()
                ->comment('Наименование статуса пользователя'),

            AttributeRegistry::DESCRIPTION => $this->string()
                ->comment('Описание статуса пользователя'),
        ]);

        $this->batchInsert(
            TableRegistry::TABLE_NAME_USER_STATUS,
            [
                AttributeRegistry::NAME,
                AttributeRegistry::DESCRIPTION
            ],
            [
                [
                    AttributeRegistry::NAME        => 'Не активен',
                    AttributeRegistry::DESCRIPTION => 'Пользователь не активен'
                ],
                [
                    AttributeRegistry::NAME        => 'Активен',
                    AttributeRegistry::DESCRIPTION => 'Пользователь активен'
                ],
                [
                    AttributeRegistry::NAME        => 'Почта не подтверждена',
                    AttributeRegistry::DESCRIPTION => 'Почта пользователя не подтверждена'
                ]
            ]);

        $this->addForeignKey(
            'FGK-status_id-user',
            TableRegistry::TABLE_NAME_USER,
            AttributeRegistry::STATUS_ID,
            TableRegistry::TABLE_NAME_USER_STATUS,
            AttributeRegistry::ID
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-status_id-user', TableRegistry::TABLE_NAME_USER);
        $this->dropTable(TableRegistry::TABLE_NAME_USER);
    }
}
