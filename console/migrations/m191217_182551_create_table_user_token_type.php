<?php

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use yii\db\Migration;

/**
 * Class m191217_182551_create_table_user_token_type
 */
class m191217_182551_create_table_user_token_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            RgTable::NAME_USER_TOKEN_TYPE,
            [
                RgAttribute::ID => $this->primaryKey()
                    ->comment('Идентификатор типа токена'),

                RgAttribute::NAME => $this->string()
                    ->notNull()
                    ->comment('Наименование типа токена'),

                RgAttribute::DESCRIPTION => $this->string()
                    ->comment('Описание типа токена'),
            ]
        );

        $this->batchInsert(
            RgTable::NAME_USER_TOKEN_TYPE,
            [RgAttribute::NAME],
            [
                [
                    RgAttribute::NAME => 'Авторизация'
                ],
                [
                    RgAttribute::NAME => 'Сброс авторизации'
                ],
                [
                    RgAttribute::NAME => 'Изменение пароля'
                ],
                [
                    RgAttribute::NAME => 'Подтверждение по электронной почте'
                ],
                [
                    RgAttribute::NAME => 'Изменение электронной почты'
                ],
                [
                    RgAttribute::NAME => 'Восстановление пользователя'
                ]
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(RgTable::NAME_USER_TOKEN_TYPE);
    }
}
