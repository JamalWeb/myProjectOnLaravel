<?php

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
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

        $this->createTable(
            RgTable::NAME_USER_CHILDREN,
            [
                RgAttribute::ID => $this->primaryKey()
                    ->comment('Идентификатор ребенка пользователя'),

                RgAttribute::USER_ID => $this->integer()
                    ->notNull()
                    ->comment('Идентификатор пользователя'),

                RgAttribute::AGE => $this->integer()
                    ->notNull()
                    ->comment('Возраст'),

                RgAttribute::GENDER_ID => $this->integer()
                    ->notNull()
                    ->comment('Идентификатор пола'),

                RgAttribute::CREATED_AT => $this->timestamp()
                    ->defaultValue($defaultDate)
                    ->comment('Дата создания'),

                RgAttribute::UPDATED_AT => $this->timestamp()
                    ->defaultValue($defaultDate)
                    ->comment('Дата обновления'),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(RgTable::NAME_USER_CHILDREN);
    }
}
