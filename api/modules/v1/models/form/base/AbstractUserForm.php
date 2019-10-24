<?php

namespace api\modules\v1\models\form\base;

use common\components\helpers\FileHelper;
use common\models\user\User;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\web\UploadedFile;

abstract class AbstractUserForm extends Model
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * @var UploadedFile
     */
    public $avatar;

    public function attributeLabels()
    {
        return [
            'email'      => Yii::t('api', 'email'),
            'password'   => Yii::t('api', 'password'),
            'first_name' => Yii::t('api', 'first_name'),
            'last_name'  => Yii::t('api', 'last_name'),
            'avatar'     => Yii::t('api', 'avatar'),
            'country_id' => Yii::t('api', 'country_id'),
            'city_id'    => Yii::t('api', 'city_id'),
            'is_closed'  => Yii::t('app', 'Is Closed'),
            'is_notice'  => Yii::t('app', 'Is Notice'),
            'children'   => Yii::t('api', 'children'),
            'longitude'  => Yii::t('api', 'longitude'),
            'latitude'   => Yii::t('api', 'latitude'),
            'language'   => Yii::t('api', 'language'),
            'short_lang' => Yii::t('api', 'short_lang'),
            'timezone'   => Yii::t('api', 'timezone'),
        ];
    }

    /**
     * Загрузка аватара
     *
     * @param User $user
     * @throws Exception
     */
    public function uploadAvatar(User $user): void
    {
        if (!is_null($this->avatar)) {
            /**
             * Пути для сохранения аватарки
             */
            $baseAvatarsPath = Yii::getAlias('@uploadAvatar');
            $userAvatarPath = "{$baseAvatarsPath}/user_{$user->id}";

            /**
             * Генерация названия аватарки
             */
            $randomString = Yii::$app->security->generateRandomString(10);
            $avatarExtension = $this->avatar->extension;
            $avatarName = "{$randomString}.$avatarExtension";

            /**
             * Создание директории
             */
            FileHelper::createDir($userAvatarPath, 755);

            $avatarPath = "{$userAvatarPath}/{$avatarName}";
            $this->avatar->saveAs($avatarPath);
            $this->avatar = $avatarName;
        }
    }
}
