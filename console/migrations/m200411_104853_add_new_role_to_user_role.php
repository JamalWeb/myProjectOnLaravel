<?php

use yii\db\Migration;

/**
 * Class m200411_104853_add_new_role_to_user_role
 */
class m200411_104853_add_new_role_to_user_role extends Migration
{
    private const ROLE = 'Moderator';
    private const ROLE_DESCRIPTION = 'Модератор системы';
    private const TABLE_NAME = '{{%user_role}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert(
            self::TABLE_NAME,
            [
                'name'        => self::ROLE,
                'description' => self::ROLE_DESCRIPTION
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(
            self::TABLE_NAME,
            [
                'name' => self::ROLE
            ]
        );
    }

}
