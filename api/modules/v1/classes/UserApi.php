<?php

namespace api\modules\v1\classes;

use api\modules\v1\models\error\ValidationException;
use api\modules\v1\models\form\UserForm;
use common\components\ArrayHelper;
use common\components\EmailSendler;
use common\models\user\Children;
use common\models\user\Gender;
use common\models\user\Profile;
use common\models\user\Role;
use common\models\user\User;
use common\models\user\UserType;
use Exception;
use Yii;

class UserApi extends Api
{
    /**
     * Список гендерных принадлежностей
     *
     * @return array
     */
    public final function getGender(): array
    {
        $genders = Gender::find()->all();

        return $genders;
    }

    /**
     * Регистрация обычного пользователя
     *
     * @param array $params
     * @return array
     * @throws Exception
     */
    public final function registrationUser(array $params)
    {
        $userForm = new UserForm($params);

        if (!$userForm->validate()) {
            throw new ValidationException($userForm->getFirstErrors());
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = new User();

            $params = $user->prepareRegistration([
                'email'    => $userForm->email,
                'password' => $userForm->password,
                'role_id'  => Role::ROLE_USER,
                'type_id'  => UserType::TYPE_USER,
            ]);

            $user->setAttributes($params);
            $user->saveModel();

            $this->createProfile($user, [
                'city_id' => $userForm->city_id,
                'name'    => $userForm->name
            ]);

            $childrenList = !empty($userForm->children) ? ArrayHelper::jsonToArray($userForm->children) : [];
            $this->childAdd($user, $childrenList);

            EmailSendler::registrationConfirm($user);

            $transaction->commit();

            return [
                'success' => true,
                'message' => 'Проверьте почту'
            ];
        } catch (Exception $e) {

            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Регистрация нового бизнеса
     */
    public function registrationBusiness()
    {
    }

    private function createProfile(User $user, array $params)
    {
        $profile = new Profile([
            'name' => $params['name'],
            'city' => $params['city_id']
        ]);
    }

    /**
     * Добавляем детей пользователю
     *
     * @param User  $user
     * @param array $childrenParams
     * @throws Exception
     */
    public final function childAdd(User $user, array $childrenParams): void
    {
        if (!empty($childrenParams)) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach (ArrayHelper::generator($childrenParams) as $childParam) {
                    $childParam = ArrayHelper::merge($childParam, [
                        'user_id' => $user->id,
                    ]);

                    $child = new Children($childParam);
                    $child->saveModel();
                }

                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
    }
}
