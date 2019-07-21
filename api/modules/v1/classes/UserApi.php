<?php

namespace api\modules\v1\classes;

use api\modules\v1\models\error\ValidationException;
use api\modules\v1\models\form\UserForm;

class UserApi extends Api
{
    /**
     * Регистрация нового пользователя
     *
     * @param array $params
     * @return UserForm
     * @throws ValidationException
     */
    public final function registrationUser(array $params)
    {
        $userForm = new UserForm($params);

        if (!$userForm->validate()) {
            throw new ValidationException($userForm->getFirstErrors());
        }

        return $userForm;
    }

    /**
     * Регистрация нового бизнеса
     */
    public function registrationBusiness()
    {
    }
}
