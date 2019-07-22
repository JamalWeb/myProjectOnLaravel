<?php

namespace api\modules\v1\classes;

use api\modules\v1\models\error\ValidationException;
use api\modules\v1\models\form\UserForm;
use common\components\ArrayHelper;
use common\components\EmailSendler;
use common\models\user\Role;
use common\models\user\User;
use common\models\user\UserType;
use Exception;

class UserApi extends Api
{
    /**
     * Регистрация нового пользователя
     *
     * @param array $params
     * @return array
     * @throws ValidationException
     * @throws Exception
     */
    public final function registrationUser(array $params)
    {
        $userForm = new UserForm($params);

        if (!$userForm->validate()) {
            throw new ValidationException($userForm->getFirstErrors());
        }

        $user = new User();

        $user->setAttributes([
            'email'        => $userForm->email,
            'role_id'      => Role::ROLE_USER,
            'user_type_id' => UserType::TYPE_USER,
            'password'     => $userForm->password
        ]);

        $user->saveModel();

        $this->childAdd($user);

        EmailSendler::registrationConfirm($user);

        return [
            'success' => true,
            'message' => 'Проверьте почту'
        ];
    }

    /**
     * Регистрация нового бизнеса
     */
    public function registrationBusiness()
    {
    }

    /**
     * @param User $user
     * @throws Exception
     */
    private function childAdd(User $user)
    {
        if (!empty($this->children)) {
            $this->children = ArrayHelper::jsonToArray($this->children);
        }
    }
}
