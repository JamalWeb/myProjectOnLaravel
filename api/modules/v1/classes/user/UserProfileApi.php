<?php

namespace api\modules\v1\classes\user;

use api\modules\v1\classes\Api;
use api\modules\v1\models\error\BadRequestHttpException;
use common\models\user\User;
use common\models\user\UserProfile;
use Yii;

class UserProfileApi extends Api
{
    /**
     * Создание
     *
     * @param User  $user
     * @param array $params
     * @return UserProfile
     * @throws BadRequestHttpException
     */
    public function create(User $user, array $params): UserProfile
    {
        $defaultValue = Yii::$app->params['defaultValue'];
        $params['user_id'] = $user->id;
        $userProfile = new UserProfile($params);
        $userProfile->saveModel([
            'language'   => $userProfile->language ?? $defaultValue['language'],
            'short_lang' => $userProfile->short_lang ?? $defaultValue['short_lang'],
            'timezone'   => $userProfile->timezone ?? $defaultValue['timezone']
        ]);

        return $userProfile;
    }

    /**
     * Редактирование
     *
     * @param User  $user
     * @param array $params
     * @return UserProfile
     * @throws BadRequestHttpException
     */
    public function update(User $user, array $params): UserProfile
    {
        $userProfile = $this->findUserProfileById($user->id);

        if (!is_null($userProfile)) {
            throw new BadRequestHttpException([
                'userProfile not found!'
            ]);
        }

        $userProfile->saveModel($params);

        return $userProfile;
    }

    /**
     * Поиск пользователя
     *
     * @param int $id
     * @return UserProfile|null
     */
    public function findUserProfileById(int $id): ?UserProfile
    {
        return UserProfile::findOne(['id' => $id]);
    }
}
