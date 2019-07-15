<?php

namespace common\models;

use Yii;

/**
 * Login form
 */
class LoginForm extends \amnah\yii2\user\models\forms\LoginForm
{
    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }
}
