<?php

use common\components\registry\AttrRegistry;
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
        $this->createTable(TableRegistry::NAME_USER_STATUS, [
            AttrRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор статуса пользователя'),

            AttrRegistry::NAME => $this->string()
                ->comment('Наименование статуса пользователя'),

            AttrRegistry::DESCRIPTION => $this->string()
                ->comment('Описание статуса пользователя'),
        ]);

        $this->batchInsert(
            TableRegistry::NAME_USER_STATUS,
            [
                AttrRegistry::NAME,
                AttrRegistry::DESCRIPTION
            ],
            [
                [
                    AttrRegistry::NAME        => 'Не активен',
                    AttrRegistry::DESCRIPTION => 'Пользователь не активен'
                ],
                [
                    AttrRegistry::NAME        => 'Активен',
                    AttrRegistry::DESCRIPTION => 'Пользователь активен'
                ],
                [
                    AttrRegistry::NAME        => 'Почта не подтверждена',
                    AttrRegistry::DESCRIPTION => 'Почта пользователя не подтверждена'
                ]
            ]);

        $this->addForeignKey(
            'FGK-status_id-user',
            TableRegistry::NAME_USER,
            AttrRegistry::STATUS_ID,
            TableRegistry::NAME_USER_STATUS,
            AttrRegistry::ID
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FGK-status_id-user', TableRegistry::NAME_USER);
        $this->dropTable(TableRegistry::NAME_USER);
    }
}
