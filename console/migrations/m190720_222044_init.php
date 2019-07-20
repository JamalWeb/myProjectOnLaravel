<?php
require_once Yii::getAlias('@vendor/amnah/yii2-user/migrations/m150214_044831_init_user.php');

use yii\db\Migration;

/**
 * Class m190720_222044_init
 */
class m190720_222044_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_type}}', [
            'id'   => $this->primaryKey()->comment('Идентификатор типа пользователя'),
            'name' => $this->string()->notNull()->comment('Название'),
            'desc' => $this->string()->comment('Описание'),
        ]);

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

        (new m150214_044831_init_user())->up();

        $this->addColumn(
            '{{%user}}',
            'user_type_id',
            $this->bigInteger()
                ->after('role_id')
                ->comment('Идентификатор типа пользователя')
        );
        $this->addColumn(
            '{{%user}}',
            'is_banned',
            $this->boolean()
                ->after('updated_at')
                ->defaultValue(false)
                ->comment('Бан (1 - вкл. 0 - выкл.) | default = 0')
        );
        $this->addColumn(
            '{{%user}}',
            'logout_in_at',
            $this->timestamp()
                ->after('logged_in_at')
                ->comment('Дата выхода')
        );

        $this->addColumn(
            '{{%profile}}',
            'category_profile_id',
            $this->string()
                ->comment('Идентификатор категории пррофиля')
        );
        $this->addColumn(
            '{{%profile}}',
            'name',
            $this->string()
                ->comment('Имя')
        );
        $this->addColumn(
            '{{%profile}}',
            'surname',
            $this->string()
                ->comment('Фамилия')
        );
        $this->addColumn(
            '{{%profile}}',
            'patronymic',
            $this->string()
                ->comment('Отчество')
        );
        $this->addColumn(
            '{{%profile}}',
            'lang',
            $this->string()
                ->comment('Язык')
        );
        $this->addColumn(
            '{{%profile}}',
            'short_lang',
            $this->string()
                ->comment('Код языка')
        );
        $this->addColumn(
            '{{%profile}}',
            'about',
            $this->string()
                ->comment('Описание бизнес аккаунта')
        );
        $this->addColumn(
            '{{%profile}}',
            'country',
            $this->string()
                ->comment('Страна')
        );
        $this->addColumn(
            '{{%profile}}',
            'city',
            $this->string()
                ->comment('Город')
        );
        $this->addColumn(
            '{{%profile}}',
            'longitude',
            $this->string()
                ->comment('Координаты: долгота')
        );
        $this->addColumn(
            '{{%profile}}',
            'latitude',
            $this->string()
                ->comment('Координаты: широта')
        );

        $this->createTable('{{%category_profile}}', [
            'id'   => $this->primaryKey()->comment('Идентификатор категории профиля'),
            'name' => $this->string()->notNull()->comment('Название'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        (new m150214_044831_init_user())->down();
    }
}
