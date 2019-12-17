<?php

use common\components\registry\AttributeRegistry;
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

        $this->createTable(TableRegistry::TABLE_NAME_USER_CHILDREN, [
            AttributeRegistry::ID => $this->primaryKey()
                ->comment('Идентификатор ребенка пользователя'),

            AttributeRegistry::USER_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор пользователя'),

            AttributeRegistry::AGE => $this->integer()
                ->notNull()
                ->comment('Возраст'),

            AttributeRegistry::GENDER_ID => $this->integer()
                ->notNull()
                ->comment('Идентификатор пола'),

            AttributeRegistry::CREATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата создания'),

            AttributeRegistry::UPDATED_AT => $this->timestamp()
                ->defaultValue($defaultDate)
                ->comment('Дата обновления'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(TableRegistry::TABLE_NAME_USER_CHILDREN);
    }
}
