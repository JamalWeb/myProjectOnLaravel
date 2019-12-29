<?php

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
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

        $this->createTable(TableRegistry::NAME_USER_TYPE, [
            AttrRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор типа'),

            AttrRegistry::NAME => $this->string()
                ->notNull()
                ->comment('Наименование'),

            AttrRegistry::DESCRIPTION => $this->string()
                ->comment('Описание'),

            AttrRegistry::CREATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата создания'),

            AttrRegistry::UPDATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата обновления')
        ]);

        $this->batchInsert(
            TableRegistry::NAME_USER_TYPE,
            [
                AttrRegistry::NAME,
                AttrRegistry::DESCRIPTION
            ],
            [
                [
                    AttrRegistry::NAME        => 'System',
                    AttrRegistry::DESCRIPTION => 'Системный пользователь'
                ],
                [
                    AttrRegistry::NAME        => 'User',
                    AttrRegistry::DESCRIPTION => 'Обычный пользователь'
                ],
                [
                    AttrRegistry::NAME        => 'Business',
                    AttrRegistry::DESCRIPTION => 'Бизнес пользователь'
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::NAME_USER_TYPE);
    }
}
