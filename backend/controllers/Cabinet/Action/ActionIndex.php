<?php


namespace backend\controllers\Cabinet\Action;


use backend\controllers\Base\BaseAction;
use backend\controllers\Cabinet\CabinetController;
use backend\models\Cabinet\ProfileForm;
use backend\models\Cabinet\UserForm;

/**
 * @property-read CabinetController $controller
 * @property ProfileForm $profileForm
 * @property UserForm $userForm
 */
final class ActionIndex extends BaseAction
{
    public $profileForm;
    public $userForm;

    public function run(): string
    {
        $user = $this->controller->authorizedUser;
        $this->controller->registerMeta('Личный кабинет', '', '');

        $profileForm = $this->getProfileForm(
            [
                'firstName'   => $user->profile->first_name,
                'lastName'    => $user->profile->last_name,
                'patronymic'  => $user->profile->patronymic,
                'avatar'      => $user->profile->avatar,
                'phoneNumber' => $user->profile->phone_number,
                'address'     => $user->profile->address,
                'gender'      => $user->profile->gender->name,
            ]
        );

        $userForm = $this->getUserForm(
            [
                'username'  => $user->username,
                'email'     => $user->email,
                'createdAt' => $user->created_at,
                'updatedAt' => $user->updated_at,
                'role'      => $user->role->description,
                'type'      => $user->type->description,
            ]
        );

        return $this->controller->render(
            'index',
            [
                'userForm'    => $userForm,
                'profileForm' => $profileForm,
            ]
        );
    }


    /**
     * @param array $params
     * @return UserForm
     */
    public function getUserForm(array $params): UserForm
    {
        return new $this->userForm($params);
    }

    /**
     * @param array $params
     * @return ProfileForm
     */
    public function getProfileForm(array $params): ProfileForm
    {
        return new $this->profileForm($params);
    }

}