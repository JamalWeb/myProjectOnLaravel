<?php

namespace api\modules\v1\classes;

use api\modules\v1\classes\base\Api;
use api\modules\v1\models\error\BadRequestHttpException;
use common\components\ArrayHelper;
use common\components\registry\RgAttribute;
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
        $language = $userProfile->language ?? $defaultValue[RgAttribute::LANGUAGE];
        $shortLang = $userProfile->short_lang ?? $defaultValue[RgAttribute::SHORT_LANG];
        $timezone = $userProfile->timezone ?? $defaultValue[RgAttribute::TIMEZONE];

        $attribute = ArrayHelper::merge(
            $params,
            [
                RgAttribute::USER_ID    => $user->id,
                RgAttribute::LANGUAGE   => $language,
                RgAttribute::SHORT_LANG => $shortLang,
                RgAttribute::TIMEZONE   => $timezone,
            ]
        );

        $userProfile = new UserProfile();
        $userProfile->saveModel($attribute);

        return $userProfile;
    }

    /**
     * Редактирование
     *
     * @param User  $user
     * @param array $params
     * @return UserProfile
     * @throws BadRequestHttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function update(User $user, array $params): UserProfile
    {
        $userProfile = $this->findById($user->id);
        $userProfile->saveModel($params);

        return $userProfile;
    }

    /**
     * Поиск пользователя
     *
     * @param int $id
     * @return UserProfile
     * @throws \yii\web\BadRequestHttpException
     */
    public function findById(int $id): UserProfile
    {
        $userProfile = UserProfile::findOne([RgAttribute::ID => $id]);

        if (is_null($userProfile)) {
            throw new \yii\web\BadRequestHttpException('Профиль не найден');
        }

        return $userProfile;
    }
}
