<?php

use common\components\PassHelper;
use common\models\User;
use common\models\user\UserProfile;
use yii\base\InvalidConfigException;
use yii\db\Migration;

/**
 * Class m190713_190129_add_admin
 */
class m190713_190129_add_admin extends Migration
{
    /**
     * {@inheritdoc}
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function safeUp()
    {
        /**
         * Хелпер для работы с паролем
         *
         * @var PassHelper $passHelper
         */
        $passHelper = Yii::$app->get('passHelper');

        /**
         * Пользователь
         *
         * @var User $user
         */
        $user = User::create([
            'user_type_id' => 1,
            'email'        => 'admin@example.com',
            'password'     => $passHelper->encrypt('admin'),
        ]);

        UserProfile::create([
            'user_id' => $user->id,
            'name'    => 'Admin',
            'city'    => 'undefined',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190713_190129_add_admin cannot be reverted.\n";

        return false;
    }
}
