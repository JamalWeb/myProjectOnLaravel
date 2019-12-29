<?php

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
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

        $this->createTable(TableRegistry::NAME_USER_ROLE, [
            AttrRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор роли'),

            AttrRegistry::NAME => $this->string()
                ->notNull()
                ->comment('Наименование роли'),

            AttrRegistry::DESCRIPTION => $this->string()
                ->notNull()
                ->comment('Описание роли'),

            AttrRegistry::CREATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата создания'),

            AttrRegistry::UPDATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата обновления')
        ]);

        $this->batchInsert(
            TableRegistry::NAME_USER_ROLE,
            [
                AttrRegistry::NAME,
                AttrRegistry::DESCRIPTION
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
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::NAME_USER_ROLE);
    }
}
