<?php

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m190723_171804_create_table_children
 */
class m190723_171804_create_table_children extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $defaultDate = new Expression('CURRENT_TIMESTAMP');

        $this->createTable(TableRegistry::NAME_USER_CHILDREN, [
            AttrRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор ребенка пользователя'),

            AttrRegistry::USER_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор пользователя'),

            AttrRegistry::AGE => $this->integer()
                ->notNull()
                ->comment('Возраст'),

            AttrRegistry::GENDER_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор пола'),

            AttrRegistry::CREATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата создания'),

            AttrRegistry::UPDATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата обновления'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::NAME_USER_CHILDREN);
    }
}
