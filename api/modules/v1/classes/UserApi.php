<?php

namespace api\modules\v1\classes;

use api\modules\v1\classes\base\Api;
use api\modules\v1\models\form\base\AbstractUserForm;
use api\modules\v1\models\form\BusinessUserForm;
use common\components\PasswordHelper;
use common\models\user\UserRole;
use Yii;
use api\modules\v1\models\error\BadRequestHttpException;
use api\modules\v1\models\form\LoginForm;
use api\modules\v1\models\form\DefaultUserForm;
use common\components\ArrayHelper;
use common\components\EmailSendler;
use common\models\user\User;
use common\models\user\UserToken;
use common\models\user\UserType;
use yii\web\HeaderCollection;
use Exception;
use yii\web\UploadedFile;

class UserApi extends Api
{
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
            UserToken::generateAccessToken($user, UserToken::TYPE_AUTH, null, '+ 1 day');
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
        UserToken::generateAccessToken($user, UserToken::TYPE_AUTH, null, '+ 1 day');

        return [
            'auth_token'       => UserToken::getAccessToken($user, UserToken::TYPE_AUTH)->access_token,
            'reset_auth_token' => UserToken::getAccessToken($user, UserToken::TYPE_RESET_AUTH)->access_token
        ];
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
        $defaultUserForm->setScenario(AbstractUserForm::SCENARIO_CREATE);

        if (!$defaultUserForm->validate()) {
            throw new BadRequestHttpException($defaultUserForm->getFirstErrors());
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = new User();
            $user->saveModel([
                'type_id'    => UserType::TYPE_DEFAULT_USER,
                'role_id'    => UserRole::ROLE_DEFAULT_USER,
                'email'      => $defaultUserForm->email,
                'password'   => PasswordHelper::encrypt($defaultUserForm->password),
                'status'     => User::STATUS_UNCONFIRMED_EMAIL,
                'created_ip' => Yii::$app->request->remoteIP,
            ]);

            $userProfileApi = new UserProfileApi();
            $userProfileApi->create($user, [
                'city_id'    => $defaultUserForm->city_id,
                'first_name' => $defaultUserForm->first_name,
                'last_name'  => $defaultUserForm->last_name,
                'language'   => $defaultUserForm->language,
                'short_lang' => $defaultUserForm->short_lang,
                'timezone'   => $defaultUserForm->timezone
            ]);

            $userChildrenApi = new UserChildrenApi();
            $childrenList = ArrayHelper::jsonToArray($defaultUserForm->children);
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

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = new User();
            $user->saveModel([
                'type_id'    => UserType::TYPE_BUSINESS_USER,
                'role_id'    => UserRole::ROLE_BUSINESS_USER,
                'email'      => $businessUserForm->email,
                'password'   => PasswordHelper::encrypt($businessUserForm->password),
                'status'     => User::STATUS_UNCONFIRMED_EMAIL,
                'created_ip' => Yii::$app->request->remoteIP,
            ]);

            $userProfileApi = new UserProfileApi();
            $userProfileApi->create($user, [
                'first_name'   => $businessUserForm->first_name,
                'phone_number' => $businessUserForm->phone_number,
                'address'      => $businessUserForm->address,
                'about'        => $businessUserForm->about,
                'city_id'      => $businessUserForm->city_id,
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
     * Редактирование
     *
     * @param User  $user
     * @param array $post
     * @return array
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function updateDefaultUser(User $user, array $post): array
    {
        $defaultUserForm = new DefaultUserForm($post);
//        $defaultUserForm->setScenario(AbstractUserForm::SCENARIO_UPDATE);

        $defaultUserForm->avatar = UploadedFile::getInstanceByName('avatar');
        if ($defaultUserForm->validate()) {
            $defaultUserForm->uploadAvatar($user);
        } else {
            throw new BadRequestHttpException($defaultUserForm->getFirstErrors());
        }

//        $transaction = Yii::$app->db->beginTransaction();
//        try {
//            if (!is_null($defaultUserForm->email)) {
//                $emailExists = User::find()
//                    ->where([
//                        'AND',
//                        ['<>', 'id', $user->id],
//                        ['email' => $defaultUserForm->email],
//                    ])
//                    ->exists();
//
//                if (!$emailExists) {
//                    EmailSendler::confirmChangeEmail($user, $defaultUserForm->email);
//                }
//            }
//
//            $userProfileApi = new UserProfileApi();
//            $userProfileApi->update($user, [
//                'first_name' => $defaultUserForm->first_name,
//                'last_name'  => $defaultUserForm->last_name,
//                'avatar'     => $defaultUserForm->avatar,
//                'country_id' => $defaultUserForm->country_id,
//                'city_id'    => $defaultUserForm->city_id,
//                'is_closed'  => $defaultUserForm->is_closed,
//                'is_notice'  => $defaultUserForm->is_notice,
//                'longitude'  => $defaultUserForm->longitude,
//                'latitude'   => $defaultUserForm->latitude,
//                'language'   => $defaultUserForm->language,
//                'short_lang' => $defaultUserForm->short_lang,
//                'timezone'   => $defaultUserForm->timezone
//            ]);
//
//            $childrenList = ArrayHelper::jsonToArray($defaultUserForm->children);
//            $userChildrenApi = new UserChildrenApi();
//            $userChildrenApi->add($user, $childrenList);
//
//            $transaction->commit();
//
//            return $user->publicInfo;
//        } catch (Exception $e) {
//            $transaction->rollBack();
//            throw $e;
//        }
        return [];
    }

    /**
     * Данные пользователя
     *
     * @param array     $get
     * @param User|null $user
     * @return array
     * @throws BadRequestHttpException
     */
    public function get(array $get, User $user = null): array
    {
        if (!empty($get['user_id'])) {
            $user = $this->findUserById($get['user_id']);
        }

        return $user->publicInfo;
    }

    /**
     * Поиск пользователя
     *
     * @param int $id
     * @return User
     * @throws BadRequestHttpException
     */
    public function findUserById(int $id): User
    {
        $user = User::findOne([
            'id'        => $id,
            'type_id'   => UserType::$validTypeSearch,
            'status'    => User::STATUS_ACTIVE,
            'is_banned' => false
        ]);

        if (is_null($user)) {
            throw new BadRequestHttpException(['user' => 'User not found']);
        }

        return $user;
    }
}
