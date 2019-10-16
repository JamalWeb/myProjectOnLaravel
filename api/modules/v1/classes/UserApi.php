<?php

namespace api\modules\v1\classes;

use common\models\user\UserProfile;
use common\models\user\UserRole;
use Yii;
use api\modules\v1\models\error\BadRequestHttpException;
use api\modules\v1\models\form\LoginForm;
use api\modules\v1\models\form\UserForm;
use common\components\ArrayHelper;
//use common\components\EmailSendler;
use common\models\user\User;
use common\models\user\UserChildren;
use common\models\user\UserGender;
use common\models\user\UserToken;
use common\models\user\UserType;
use yii\web\HeaderCollection;
use Exception;

class UserApi extends Api
{
    /**
     * Список гендерных принадлежностей
     *
     * @return array
     */
    public final function getGender(): array
    {
        return UserGender::find()->all();
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
                'type_id'  => UserType::TYPE_DEFAULT_USER,
                'role_id'  => UserRole::ROLE_DEFAULT_USER,
                'email'    => $userForm->email,
                'password' => $userForm->password,
            ]);
            $user->saveModel($params);

            $this->createProfile($user, [
                'city_id'    => $userForm->city_id,
                'country_id' => $userForm->country_id,
                'first_name' => $userForm->first_name,
                'last_name'  => $userForm->last_name,
                'longitude'  => $userForm->longitude,
                'latitude'   => $userForm->latitude,
                'language'   => $userForm->language,
                'short_lang' => $userForm->short_lang,
                'timezone'   => $userForm->timezone
            ]);

            $childrenList = ArrayHelper::jsonToArray($userForm->children);
            $this->childAdd($user, $childrenList);

//            EmailSendler::registrationConfirm($user);

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
     * @return UserProfile
     * @throws BadRequestHttpException
     */
    private function createProfile(User $user, array $params): UserProfile
    {
        $defaultValue = Yii::$app->params['defaultValue'];
        $profile = new UserProfile();
        $profile->saveModel([
            'user_id'    => $user->id,
            'first_name' => $params['first_name'],
            'last_name'  => $params['last_name'],
            'patronymic' => $params['patronymic'] ?? null,
            'gender_id'  => $params['gender_id'] ?? null,
            'about'      => $params['about'] ?? null,
            'country_id' => $params['country_id'],
            'city_id'    => $params['city_id'],
            'longitude'  => $params['longitude'],
            'latitude'   => $params['latitude'],
            'language'   => $params['language'] ?? $defaultValue['language'],
            'short_lang' => $params['short_lang'] ?? $defaultValue['short_lang'],
            'timezone'   => $params['timezone'] ?? $defaultValue['timezone']
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
        if (empty($childrenParams)) {
            return $children;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($childrenParams as $childParam) {
                $childParam = ArrayHelper::merge($childParam, [
                    'user_id' => $user->id
                ]);

                $child = new UserChildren();
                $child->saveModel($childParam);

                $children[] = $child;
            }

            $transaction->commit();

            return $children;
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
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
