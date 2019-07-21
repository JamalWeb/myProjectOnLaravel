<?php
require_once Yii::getAlias('@yii/i18n/migrations/m150207_210500_i18n_init.php');

use yii\db\Migration;

/**
 * Class m190721_221008_add_transalte
 */
class m190721_221008_add_transalte extends Migration
{
    public $translations_ru = [
        'city_id'  => 'Город',
        'name'     => 'Имя',
        'email'    => 'Почтовый адрес',
        'password' => 'Пароль',
        'children' => 'Список детей',
    ];

    public $translations_en = [
        'city_id'  => 'City',
        'name'     => 'Name',
        'email'    => 'Email',
        'password' => 'Password',
        'children' => 'Child list',
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        (new m150207_210500_i18n_init())->up();
        \console\components\TranslateHelper::insertCategory('ru', 'api', $this->translations_ru);
        \console\components\TranslateHelper::insertCategory('en', 'api', $this->translations_en);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        \console\components\TranslateHelper::deleteCategory('en', 'api', $this->translations_en);
        \console\components\TranslateHelper::deleteCategory('ru', 'api', $this->translations_ru);
        (new m150207_210500_i18n_init())->down();
    }
}
