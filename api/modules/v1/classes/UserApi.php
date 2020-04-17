<?php

namespace api\modules\v1\classes;

use api\modules\v1\classes\base\Api;
use api\modules\v1\models\error\BadRequestHttpException;
use api\modules\v1\models\form\BusinessUserForm;
use api\modules\v1\models\form\DefaultUserForm;
use api\modules\v1\models\form\LoginForm;
use common\components\ArrayHelper;
use common\components\EmailSender;
use common\components\PasswordHelper;
use common\components\registry\RgAttribute;
use common\components\registry\RgUser;
use common\models\user\User;
use common\models\user\UserGender;
use common\models\user\UserToken;
use Exception;
use Yii;
use yii\web\HeaderCollection;

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
        ArrayHelper::cleaning(
            $post,
            [
                RgAttribute::EMAIL,
                RgAttribute::PASSWORD
            ]
        );

        $loginForm = new LoginForm($post);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            /** @var User $user */
            $user = $loginForm->authenticate();
            UserToken::generateAccessToken(
                $user,
                RgUser::TOKEN_TYPE_AUTH,
                null,
                '+ 1 day'
            );
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return [
            RgAttribute::AUTH_TOKEN       => UserToken::get($user, RgUser::TOKEN_TYPE_AUTH)->access_token,
            RgAttribute::RESET_AUTH_TOKEN => UserToken::get($user, RgUser::TOKEN_TYPE_RESET_AUTH)->access_token
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
        $userToken = UserToken::findOne(
            [
                RgAttribute::TYPE_ID      => RgUser::TOKEN_TYPE_RESET_AUTH,
                RgAttribute::ACCESS_TOKEN => $headers[RgAttribute::HEADER_RESET_AUTH_TOKEN]
            ]
        );

        if ($userToken === null) {
            throw new BadRequestHttpException(
                [
                    RgAttribute::HEADER_RESET_AUTH_TOKEN => 'Не является действительным'
                ]
            );
        }

        $user = $userToken->user;

        UserToken::generateAccessToken($user, RgUser::TOKEN_TYPE_AUTH, null, '+ 1 day');

        $authUserToken = UserToken::get($user, RgUser::TOKEN_TYPE_AUTH);
        $resetAuthUserToken = UserToken::get($user, RgUser::TOKEN_TYPE_RESET_AUTH);

        return [
            RgAttribute::AUTH_TOKEN       => $authUserToken->access_token,
            RgAttribute::RESET_AUTH_TOKEN => $resetAuthUserToken->access_token
        ];
    }

    /**
     * Список гендерных принадлежностей
     *
     * @return array
     */
    final public function getGenderList(): array
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
    final public function createDefault(array $post): array
    {
        $allowedAttribute = [
            RgAttribute::EMAIL,
            RgAttribute::PASSWORD,
            RgAttribute::FIRST_NAME,
            RgAttribute::LAST_NAME,
            RgAttribute::CITY_ID,
            RgAttribute::LANGUAGE,
            RgAttribute::SHORT_LANG,
            RgAttribute::TIMEZONE,
            RgAttribute::CHILDREN
        ];
        ArrayHelper::cleaning($post, $allowedAttribute);

        $defaultUserForm = new DefaultUserForm($post);
        if (!$defaultUserForm->validate()) {
            throw new BadRequestHttpException($defaultUserForm->getFirstErrors());
        }

        $user = new User();
        $userProfileApi = new UserProfileApi();
        $userChildrenApi = new UserChildrenApi();
        $userData = [
            RgAttribute::TYPE_ID    => RgUser::TYPE_DEFAULT,
            RgAttribute::ROLE_ID    => RgUser::ROLE_DEFAULT,
            RgAttribute::EMAIL      => $defaultUserForm->email,
            RgAttribute::PASSWORD   => PasswordHelper::encrypt($defaultUserForm->password),
            RgAttribute::STATUS_ID  => RgUser::STATUS_UNCONFIRMED_EMAIL,
            RgAttribute::CREATED_IP => Yii::$app->request->remoteIP,
        ];
        $userProfileData = [
            RgAttribute::CITY_ID    => $defaultUserForm->city_id,
            RgAttribute::FIRST_NAME => $defaultUserForm->first_name,
            RgAttribute::LAST_NAME  => $defaultUserForm->last_name,
            RgAttribute::LANGUAGE   => $defaultUserForm->language,
            RgAttribute::SHORT_LANG => $defaultUserForm->short_lang,
            RgAttribute::TIMEZONE   => $defaultUserForm->timezone
        ];
        $childrenList = ArrayHelper::jsonToArray($defaultUserForm->children);
        $accessData = [
            RgAttribute::EMAIL    => $defaultUserForm->email,
            RgAttribute::PASSWORD => $defaultUserForm->password,
        ];

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user->saveModel($userData);
            $userProfileApi->create($user, $userProfileData);
            $userChildrenApi->add($user, $childrenList);
            $access = $this->login($accessData);
            $userData = $user->publicInfo;
            $userData[RgAttribute::ACCESS] = $access;

            EmailSender::registrationConfirmDefaultUser($user);

            $transaction->commit();

            return $userData;
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
    public function registrationBusiness(array $post): array
    {
        $allowedAttribute = [
            RgAttribute::EMAIL,
            RgAttribute::PASSWORD,
            RgAttribute::FIRST_NAME,
            RgAttribute::PHONE_NUMBER,
            RgAttribute::ADDRESS,
            RgAttribute::ABOUT,
            RgAttribute::CITY_ID,
            RgAttribute::LANGUAGE,
            RgAttribute::SHORT_LANG,
            RgAttribute::TIMEZONE
        ];
        ArrayHelper::cleaning($post, $allowedAttribute);

        $businessUserForm = new BusinessUserForm($post);
        if (!$businessUserForm->validate()) {
            throw new BadRequestHttpException($businessUserForm->getFirstErrors());
        }

        $user = new User();
        $userProfileApi = new UserProfileApi();
        $userData = [
            RgAttribute::TYPE_ID    => RgUser::TYPE_BUSINESS,
            RgAttribute::ROLE_ID    => RgUser::ROLE_BUSINESS,
            RgAttribute::EMAIL      => $businessUserForm->email,
            RgAttribute::PASSWORD   => PasswordHelper::encrypt($businessUserForm->password),
            RgAttribute::STATUS_ID  => RgUser::STATUS_UNCONFIRMED_EMAIL,
            RgAttribute::CREATED_IP => Yii::$app->request->remoteIP,
        ];
        $userProfileData = [
            RgAttribute::FIRST_NAME   => $businessUserForm->first_name,
            RgAttribute::PHONE_NUMBER => $businessUserForm->phone_number,
            RgAttribute::ADDRESS      => $businessUserForm->address,
            RgAttribute::ABOUT        => $businessUserForm->about,
            RgAttribute::CITY_ID      => $businessUserForm->city_id,
            RgAttribute::LANGUAGE     => $businessUserForm->language,
            RgAttribute::SHORT_LANG   => $businessUserForm->short_lang,
            RgAttribute::TIMEZONE     => $businessUserForm->timezone
        ];
        $accessData = [
            RgAttribute::EMAIL    => $businessUserForm->email,
            RgAttribute::PASSWORD => $businessUserForm->password,
        ];

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user->saveModel($userData);
            $userProfileApi->create($user, $userProfileData);
            $access = $this->login($accessData);
            $userData = $user->publicInfo;
            $userData[RgAttribute::ACCESS] = $access;

            EmailSender::registrationConfirmBusinessUser($user);

            $transaction->commit();

            return $userData;
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Данные пользователя
     *
     * @param User|null $user
     * @param array     $get
     * @return array
     * @throws \yii\web\BadRequestHttpException
     */
    public function get(User $user, array $get): array
    {
        if (!empty($get[RgAttribute::ID])) {
            $user = self::findUserById($get[RgAttribute::ID]);
        }

        return $user->publicInfo;
    }

    /**
     * Поиск пользователя
     *
     * @param int $id
     * @return User
     * @throws \yii\web\BadRequestHttpException
     */
    public static function findUserById(int $id): User
    {
        $typeList = RgUser::getTypeList();
        $typeIdList = ArrayHelper::getColumn($typeList, RgAttribute::ID);

        $user = User::findOne(
            [
                RgAttribute::ID        => $id,
                RgAttribute::TYPE_ID   => $typeIdList,
                RgAttribute::STATUS_ID => [
                    RgUser::STATUS_ACTIVE,
                    RgUser::STATUS_UNCONFIRMED_EMAIL
                ],
                RgAttribute::IS_BANNED => false
            ]
        );

        if ($user === null) {
            throw new \yii\web\BadRequestHttpException('User not found');
        }

        return $user;
    }

    /**
     * Воостановление аккаунта
     *
     * @param array $post
     * @return array
     * @throws BadRequestHttpException
     * @throws \yii\base\Exception
     */
    public function recovery(array $post): array
    {
        ArrayHelper::validateParams($post, [RgAttribute::EMAIL]);

        $user = User::findOne(
            [
                RgAttribute::EMAIL => $post[RgAttribute::EMAIL]
            ]
        );

        if ($user === null) {
            throw new BadRequestHttpException(
                [
                    RgAttribute::EMAIL => 'Email is not found'
                ]
            );
        }

        $result = EmailSender::userRecovery($user);

        return [
            RgAttribute::SUCCESS => $result
        ];
    }
}
