<?php

namespace api\modules\v1\classes;

use api\modules\v1\models\form\BusinessUserForm;
use common\models\user\UserRole;
use Yii;
use api\modules\v1\models\error\BadRequestHttpException;
use api\modules\v1\models\form\LoginForm;
use api\modules\v1\models\form\DefaultUserForm;
use common\components\ArrayHelper;
use common\components\EmailSendler;
use common\models\user\User;
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
     * @param array $post
     * @return array
     * @throws Exception
     */
    public final function registrationDefaultUser(array $post): array
    {
        $defaultUserForm = new DefaultUserForm($post);

        if (!$defaultUserForm->validate()) {
            throw new BadRequestHttpException($defaultUserForm->getFirstErrors());
        }

        $post = [
            'type_id'  => UserType::TYPE_DEFAULT_USER,
            'role_id'  => UserRole::ROLE_DEFAULT_USER,
            'email'    => $defaultUserForm->email,
            'password' => $defaultUserForm->password,
        ];

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = new User();
            $user->prepareRegistration($post);
            $user->saveModel();

            $userProfileApi = new UserProfileApi();
            $userProfileApi->create($user, [
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
            $userChildrenApi = new UserChildrenApi();
            $userChildrenApi->add($user, $childrenList);

            EmailSendler::registrationConfirmDefaultUser($user);

            $transaction->commit();

            return $user->publicInfo;
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Регистрация бизнес пользователя
     *
     * @param array $post
     * @return array
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function registrationBusinessUser(array $post): array
    {
        $businessUserForm = new BusinessUserForm($post);

        if (!$businessUserForm->validate()) {
            throw new BadRequestHttpException($businessUserForm->getFirstErrors());
        }

        $post = [
            'type_id'  => UserType::TYPE_BUSINESS_USER,
            'role_id'  => UserRole::ROLE_BUSINESS_USER,
            'email'    => $businessUserForm->email,
            'password' => $businessUserForm->password,
        ];

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = new User();
            $user->prepareRegistration($post);
            $user->saveModel();

            $userProfileApi = new UserProfileApi();
            $userProfileApi->create($user, [
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

            return $user->publicInfo;
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

        $transaction = Yii::$app->db->beginTransaction();
        try {
            /** @var User $user */
            $user = $loginForm->authenticate();
            UserToken::generateAccessToken($user, UserToken::TYPE_AUTH, '+ 1 day');
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return [
            'auth_token'       => UserToken::getAccessToken($user, UserToken::TYPE_AUTH)->access_token,
            'reset_auth_token' => UserToken::getAccessToken($user, UserToken::TYPE_RESET_AUTH)->access_token
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
            'type'         => UserToken::TYPE_RESET_AUTH,
            'access_token' => $headers['reset-auth-token']
        ]);

        if (is_null($userToken)) {
            throw new BadRequestHttpException([
                'reset-auth-token' => 'Токен не является действительным'
            ]);
        }

        $user = $userToken->user;
        UserToken::generateAccessToken($user, UserToken::TYPE_AUTH, '+ 1 day');

        return [
            'auth_token'       => UserToken::getAccessToken($user, UserToken::TYPE_AUTH)->access_token,
            'reset_auth_token' => UserToken::getAccessToken($user, UserToken::TYPE_RESET_AUTH)->access_token
        ];
    }

    /**
     * Поиск пользователя
     *
     * @param int $id
     * @return User|null
     */
    public function findUserById(int $id): ?User
    {
        return User::findOne([
            'id'        => $id,
            'is_banned' => false,
            'status'    => User::STATUS_ACTIVE,
            'type_id'   => UserType::$validTypeSearch
        ]);
    }
}
