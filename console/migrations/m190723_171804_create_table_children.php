<?php

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
        $this->createTable('{{%children}}', [
            'id'         => $this->primaryKey()->comment('Идентификатор ребенка пользователя'),
            'user_id'    => $this->integer()->notNull()->comment('Идентификатор пользователя'),
            'age'        => $this->integer()->notNull()->comment('Возраст ребенка'),
            'gender'     => $this->string(15)->notNull()->comment('Пол ребенка'),
            'created_at' => $this->timestamp()->comment('Дата создания'),
            'updated_at' => $this->timestamp()->comment('Дата последнего обновления'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%children}}');
    }
}
