<?php

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m191014_173703_create_table_user_type
 */
class m191014_173703_create_table_user_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $defaultDate = new Expression('CURRENT_TIMESTAMP');

        $this->createTable(
            RgTable::NAME_USER_TYPE,
            [
                RgAttribute::ID => $this->primaryKey()
                    ->comment('Идентификатор типа'),

                RgAttribute::NAME => $this->string()
                    ->notNull()
                    ->comment('Наименование'),

                RgAttribute::DESCRIPTION => $this->string()
                    ->comment('Описание'),

                RgAttribute::CREATED_AT => $this->timestamp()
                    ->defaultValue($defaultDate)
                    ->comment('Дата создания'),

                RgAttribute::UPDATED_AT => $this->timestamp()
                    ->defaultValue($defaultDate)
                    ->comment('Дата обновления')
            ]
        );

        $this->batchInsert(
            RgTable::NAME_USER_TYPE,
            [
                RgAttribute::NAME,
                RgAttribute::DESCRIPTION
            ],
            [
                [
                    RgAttribute::NAME        => 'System',
                    RgAttribute::DESCRIPTION => 'Системный пользователь'
                ],
                [
                    RgAttribute::NAME        => 'User',
                    RgAttribute::DESCRIPTION => 'Обычный пользователь'
                ],
                [
                    RgAttribute::NAME        => 'Business',
                    RgAttribute::DESCRIPTION => 'Бизнес пользователь'
                ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(RgTable::NAME_USER_TYPE);
    }
}
