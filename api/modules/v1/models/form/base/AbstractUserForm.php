<?php

namespace api\modules\v1\models\form\base;

use common\components\helpers\FileHelper;
use common\components\registry\RgAttribute;
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
            RgAttribute::EMAIL      => Yii::t('api', 'email'),
            RgAttribute::PASSWORD   => Yii::t('api', 'password'),
            RgAttribute::FIRST_NAME => Yii::t('api', 'first_name'),
            RgAttribute::LAST_NAME  => Yii::t('api', 'last_name'),
            RgAttribute::AVATAR     => Yii::t('api', 'avatar'),
            RgAttribute::COUNTRY_ID => Yii::t('api', 'country_id'),
            RgAttribute::CITY_ID    => Yii::t('api', 'city_id'),
            RgAttribute::IS_CLOSED  => Yii::t('app', 'Is Closed'),
            RgAttribute::IS_NOTICE  => Yii::t('app', 'Is Notice'),
            RgAttribute::CHILDREN   => Yii::t('api', 'children'),
            RgAttribute::LONGITUDE  => Yii::t('api', 'longitude'),
            RgAttribute::LATITUDE   => Yii::t('api', 'latitude'),
            RgAttribute::LANGUAGE   => Yii::t('api', 'language'),
            RgAttribute::SHORT_LANG => Yii::t('api', 'short_lang'),
            RgAttribute::TIMEZONE   => Yii::t('api', 'timezone'),
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
