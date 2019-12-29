<?php

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
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
        $this->createTable(
            RgTable::NAME_USER_STATUS,
            [
                RgAttribute::ID => $this->primaryKey()
                    ->comment('Идентификатор статуса пользователя'),

                RgAttribute::NAME => $this->string()
                    ->comment('Наименование статуса пользователя'),

                RgAttribute::DESCRIPTION => $this->string()
                    ->comment('Описание статуса пользователя'),
            ]
        );

        $this->batchInsert(
            RgTable::NAME_USER_STATUS,
            [
                RgAttribute::NAME,
                RgAttribute::DESCRIPTION
            ],
            [
                [
                    RgAttribute::NAME        => 'Не активен',
                    RgAttribute::DESCRIPTION => 'Пользователь не активен'
                ],
                [
                    RgAttribute::NAME        => 'Активен',
                    RgAttribute::DESCRIPTION => 'Пользователь активен'
                ],
                [
                    RgAttribute::NAME        => 'Почта не подтверждена',
                    RgAttribute::DESCRIPTION => 'Почта пользователя не подтверждена'
                ]
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(RgTable::NAME_USER_STATUS);
    }
}
