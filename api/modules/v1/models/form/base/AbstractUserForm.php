<?php

namespace api\modules\v1\models\form\base;

use common\components\helpers\FileHelper;
use common\components\registry\AttrRegistry;
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
            AttrRegistry::EMAIL      => Yii::t('api', 'email'),
            AttrRegistry::PASSWORD   => Yii::t('api', 'password'),
            AttrRegistry::FIRST_NAME => Yii::t('api', 'first_name'),
            AttrRegistry::LAST_NAME  => Yii::t('api', 'last_name'),
            AttrRegistry::AVATAR     => Yii::t('api', 'avatar'),
            AttrRegistry::COUNTRY_ID => Yii::t('api', 'country_id'),
            AttrRegistry::CITY_ID    => Yii::t('api', 'city_id'),
            AttrRegistry::IS_CLOSED  => Yii::t('app', 'Is Closed'),
            AttrRegistry::IS_NOTICE  => Yii::t('app', 'Is Notice'),
            AttrRegistry::CHILDREN   => Yii::t('api', 'children'),
            AttrRegistry::LONGITUDE  => Yii::t('api', 'longitude'),
            AttrRegistry::LATITUDE   => Yii::t('api', 'latitude'),
            AttrRegistry::LANGUAGE   => Yii::t('api', 'language'),
            AttrRegistry::SHORT_LANG => Yii::t('api', 'short_lang'),
            AttrRegistry::TIMEZONE   => Yii::t('api', 'timezone'),
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
