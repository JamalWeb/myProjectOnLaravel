<?php

namespace api\modules\v1\classes;

use api\modules\v1\models\form\BusinessUserForm;
use common\models\user\UserProfile;
use common\models\user\UserRole;
use Yii;
use api\modules\v1\models\error\BadRequestHttpException;
use api\modules\v1\models\form\LoginForm;
use api\modules\v1\models\form\DefaultUserForm;
use common\components\ArrayHelper;
use common\components\EmailSendler;
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
    public final function registrationDefaultUser(array $params): array
    {
        $defaultUserForm = new DefaultUserForm($params);

        if (!$defaultUserForm->validate()) {
            throw new BadRequestHttpException($defaultUserForm->getFirstErrors());
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = new User();
            $params = $user->prepareRegistration([
                'type_id'  => UserType::TYPE_DEFAULT_USER,
                'role_id'  => UserRole::ROLE_DEFAULT_USER,
                'email'    => $defaultUserForm->email,
                'password' => $defaultUserForm->password,
            ]);
            $user->saveModel($params);

            $this->createUserProfile($user, [
                'city_id'    => $defaultUserForm->city_id,
                'country_id' => $defaultUserForm->country_id,
                'first_name' => $defaultUserForm->first_name,
                'last_name'  => $defaultUserForm->last_name,
                'longitude'  => $defaultUserForm->longitude,
                'latitude'   => $defaultUserForm->latitude,
                'language'   => $defaultUserForm->language,
                'short_lang' => $defaultUserForm->short_lang,
                'timezone'   => $defaultUserForm->timezone
            ]);

            $childrenList = ArrayHelper::jsonToArray($defaultUserForm->children);
            $this->childAdd($user, $childrenList);

            EmailSendler::registrationConfirmDefaultUser($user);

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
     *
     * @param array $params
     * @return array
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function registrationBusinessUser(array $params): array
    {
        $businessUserForm = new BusinessUserForm($params);

        if (!$businessUserForm->validate()) {
            throw new BadRequestHttpException($businessUserForm->getFirstErrors());
        }

        $params = [
            'type_id'  => UserType::TYPE_BUSINESS_USER,
            'role_id'  => UserRole::ROLE_BUSINESS_USER,
            'email'    => $businessUserForm->email,
            'password' => $businessUserForm->password,
        ];

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = new User();
            $user->prepareRegistration($params);
            $user->saveModel($params);

            $this->createUserProfile($user, [
                'first_name'   => $businessUserForm->first_name,
                'phone_number' => $businessUserForm->phone_number,
                'address'      => $businessUserForm->address,
                'about'        => $businessUserForm->about,
                'country_id'   => $businessUserForm->country_id,
                'city_id'      => $businessUserForm->city_id,
                'longitude'    => $businessUserForm->longitude,
                'latitude'     => $businessUserForm->latitude,
                'language'     => $businessUserForm->language,
                'short_lang'   => $businessUserForm->short_lang,
                'timezone'     => $businessUserForm->timezone
            ]);

            EmailSendler::registrationConfirmBusinessUser($user);

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
     * Создание профиля для пользователя
     *
     * @param User  $user
     * @param array $params
     * @return UserProfile
     * @throws BadRequestHttpException
     */
    public function createUserProfile(User $user, array $params): UserProfile
    {
        $defaultValue = Yii::$app->params['defaultValue'];
        $userProfile = new UserProfile();
        $userProfile->saveModel([
            'user_id'      => $user->id,
            'first_name'   => $params['first_name'],
            'last_name'    => $params['last_name'] ?? null,
            'patronymic'   => $params['patronymic'] ?? null,
            'phone_number' => $params['phone_number'] ?? null,
            'address'      => $params['address'] ?? null,
            'gender_id'    => $params['gender_id'] ?? null,
            'about'        => $params['about'] ?? null,
            'country_id'   => $params['country_id'],
            'city_id'      => $params['city_id'],
            'longitude'    => $params['longitude'],
            'latitude'     => $params['latitude'],
            'language'     => $params['language'] ?? $defaultValue['language'],
            'short_lang'   => $params['short_lang'] ?? $defaultValue['short_lang'],
            'timezone'     => $params['timezone'] ?? $defaultValue['timezone']
        ]);

        return $userProfile;
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
        $user->generateToken(UserToken::TYPE_AUTH, true);

        return [
            'auth_token'       => $user->getToken(UserToken::TYPE_AUTH),
            'reset_auth_token' => $user->getToken(UserToken::TYPE_RESET_AUTH)
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
            'type'  => UserToken::TYPE_RESET_AUTH,
            'token' => $headers['reset-auth-token']
        ]);

        if (is_null($userToken)) {
            throw new BadRequestHttpException([
                'reset-auth-token' => 'Токен является недействительным'
            ]);
        }

        $user = $userToken->user;
        UserToken::generateAccessToken($user, UserToken::TYPE_AUTH, true);

        return [
            'auth_token'       => $userToken->getAccessToken($user, UserToken::TYPE_AUTH),
            'reset_auth_token' => $userToken->getAccessToken($user, UserToken::TYPE_RESET_AUTH)
        ];
    }
}
