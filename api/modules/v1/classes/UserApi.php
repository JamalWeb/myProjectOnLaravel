<?php

namespace api\modules\v1\classes;

use api\modules\v1\models\error\ValidationException;
use api\modules\v1\models\form\UserForm;
use Exception;

class UserApi extends Api
{
    /**
     * Регистрация нового пользователя
     *
     * @param array $params
     * @return UserForm
     * @throws ValidationException
     * @throws Exception
     */
    public final function registrationUser(array $params)
    {
        $userForm = new UserForm($params);

        if (!$userForm->validate()) {
            throw new ValidationException($userForm->getFirstErrors());
        }

        $result = $userForm->create();

        return $result;
    }

    /**
     * Регистрация нового бизнеса
     */
    public function registrationBusiness()
    {
    }
}
