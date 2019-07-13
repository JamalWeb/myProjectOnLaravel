<?php

use yii\db\Migration;

/**
 * Class m190713_111102_apply_default_setting
 */
class m190713_111102_apply_default_setting extends Migration
{
    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function safeUp()
    {
        $this->truncateTable('{{%user_type}}');
        $this->execute('ALTER SEQUENCE user_type_id_seq RESTART WITH 1');
        $this->batchInsert('{{%user_type}}', ['name', 'desc'], [
            [
                'name' => 'System',
                'desc' => 'Системный аккаунт'
            ],
            [
                'name' => 'User',
                'desc' => 'Обычный аккаунт'
            ],
            [
                'name' => 'Business',
                'desc' => 'Бизнес аккаунт'
            ],
        ]);

        $this->dropColumn('{{%user}}', 'profile_id');
        $this->addColumn('{{user_profile}}', 'created_at', $this->timestamp()
            ->comment('Дата создания'));
        $this->addColumn('{{user_profile}}', 'updated_at', $this->timestamp()
            ->comment('Дата последнего обновления'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190713_111102_apply_default_setting cannot be reverted.\n";

        return false;
    }
}
