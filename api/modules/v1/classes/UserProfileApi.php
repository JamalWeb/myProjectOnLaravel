<?php

namespace api\modules\v1\classes;

use api\modules\v1\models\error\BadRequestHttpException;
use api\modules\v1\models\form\DefaultUserForm;
use common\components\ArrayHelper;
use common\models\user\User;
use common\models\user\UserProfile;
use Yii;

class UserProfileApi extends Api
{
    /**
     * Создание профиля для пользователя
     *
     * @param User  $user
     * @param array $params
     * @return UserProfile
     * @throws BadRequestHttpException
     */
    public function create(User $user, array $params): UserProfile
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
     * Получить данные пользователя
     *
     * @param array $get
     * @return array
     * @throws BadRequestHttpException
     */
    public function get(array $get): array
    {
        ArrayHelper::validateRequestParams($get, ['user_id'], false);

        $userApi = new UserApi();
        $user = $userApi->findUserById($get['user_id']);

        if (is_null($user)) {
            throw new BadRequestHttpException(['user' => 'User not found']);
        }

        return $user->publicInfo;
    }

    /**
     * @param User  $user
     * @param array $post
     * @return array
     * @throws BadRequestHttpException
     */
    public function updateDefaultUser(User $user, array $post): array
    {
        $defaultUserForm = new DefaultUserForm($post);

        if (!$defaultUserForm->validate()) {
            throw new BadRequestHttpException($defaultUserForm->getFirstErrors());
        }

        return $user->publicInfo;
    }
}
