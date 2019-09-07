<?php

namespace api\modules\v1\classes;

use api\modules\v1\models\error\BadRequestHttpException;
use api\modules\v1\models\form\LoginForm;
use api\modules\v1\models\form\UserForm;
use common\components\ArrayHelper;
use common\components\EmailSendler;
use common\models\user\Children;
use common\models\user\Gender;
use common\models\user\Profile;
use common\models\user\Role;
use common\models\user\User;
use common\models\user\UserToken;
use common\models\user\UserType;
use Exception;
use Yii;
use yii\web\HeaderCollection;

class UserApi extends Api
{
    /**
     * Список гендерных принадлежностей
     *
     * @return array
     */
    public final function getGender(): array
    {
        return Gender::find()->all();
    }

    /**
     * Регистрация обычного пользователя
     *
     * @param array $params
     * @return array
     * @throws Exception
     */
    public final function registrationUser(array $params): array
    {
        $userForm = new UserForm($params);

        if (!$userForm->validate()) {
            throw new BadRequestHttpException($userForm->getFirstErrors());
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
    public function registrationBusinessUser(): array
    {
        return [];
    }

    /**
     * Создание профиля для пользователя
     *
     * @param User  $user
     * @param array $params
     * @return Profile
     */
    private function createProfile(User $user, array $params): Profile
    {
        $profile = new Profile([
            'name' => $params['name'],
            'city' => $params['city_id']
        ]);

        return $profile;
    }

    /**
     * Добавление детей пользователю
     *
     * @param User  $user
     * @param array $childrenParams
     * @return array
     * @throws Exception
     */
    public final function childAdd(User $user, array $childrenParams): array
    {
        $children = [];
        if (!empty($childrenParams)) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach (ArrayHelper::generator($childrenParams) as $childParam) {
                    $childParam['user_id'] = $user->id;

                    $child = new Children($childParam);
                    $child->saveModel();

                    $children[] = $child;
                }

                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $children;
    }

    /**
     * Авторизация
     *
     * @param array $post
     * @return array
     * @throws Exception
     */
    public function login(array $post): array
    {
        ArrayHelper::validateRequestParams($post, ['email', 'password'], false);

        /** @var LoginForm $loginForm */
        $loginForm = new LoginForm([
            'email'    => $post['email'],
            'password' => $post['password']
        ]);

        /** @var User $user */
        $user = $loginForm->authenticate();
        $user->generateToken(UserToken::TYPE_AUTH_TOKEN, true);

        return [
            'auth_token'       => $user->getToken(UserToken::TYPE_AUTH_TOKEN),
            'reset_auth_token' => $user->getToken(UserToken::TYPE_RESET_AUTH_TOKEN)
        ];
    }

    /**
     * Сброс токена аутентификации
     *
     * @param HeaderCollection $headers
     * @return array
     * @throws BadRequestHttpException
     * @throws \yii\base\Exception
     */
    public function resetAuthToken(HeaderCollection $headers)
    {
        $headers = ArrayHelper::toArray($headers);
        ArrayHelper::validateRequestParams($headers, ['reset-auth-token'], false);

        $userToken = UserToken::findOne([
            'type'  => UserToken::TYPE_RESET_AUTH_TOKEN,
            'token' => $headers['reset-auth-token']
        ]);

        if (is_null($userToken)) {
            throw new BadRequestHttpException([
                'reset-auth-token' => 'Токен является недействительным'
            ]);
        }

        $user = $userToken->user;
        $user->generateToken(UserToken::TYPE_AUTH_TOKEN, true);

        return [
            'auth_token'       => $user->getToken(UserToken::TYPE_AUTH_TOKEN),
            'reset_auth_token' => $user->getToken(UserToken::TYPE_RESET_AUTH_TOKEN)
        ];
    }
}
