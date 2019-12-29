<?php

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m191014_174852_create_table_user_role
 */
class m191014_174852_create_table_user_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $defaultDate = new Expression('CURRENT_TIMESTAMP');

        $this->createTable(
            RgTable::NAME_USER_ROLE,
            [
                RgAttribute::ID => $this->primaryKey()
                    ->comment('Идентификатор роли'),

                RgAttribute::NAME => $this->string()
                    ->notNull()
                    ->comment('Наименование роли'),

                RgAttribute::DESCRIPTION => $this->string()
                    ->notNull()
                    ->comment('Описание роли'),

                RgAttribute::CREATED_AT => $this->timestamp()
                    ->defaultValue($defaultDate)
                    ->comment('Дата создания'),

                RgAttribute::UPDATED_AT => $this->timestamp()
                    ->defaultValue($defaultDate)
                    ->comment('Дата обновления')
            ]
        );

        $this->batchInsert(
            RgTable::NAME_USER_ROLE,
            [
                RgAttribute::NAME,
                RgAttribute::DESCRIPTION
            ],
            [
                [
                    'Admin',
                    'Администратор',
                ],
                [
                    'User',
                    'Обычный пользователь'
                ],
                [
                    'Business',
                    'Бизнес пользователь'
                ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(RgTable::NAME_USER_ROLE);
    }
}
