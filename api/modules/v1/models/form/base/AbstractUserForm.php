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
            RgAttribute::EMAIL      => Yii::t('app', 'email'),
            RgAttribute::PASSWORD   => Yii::t('app', 'password'),
            RgAttribute::FIRST_NAME => Yii::t('app', 'first_name'),
            RgAttribute::LAST_NAME  => Yii::t('app', 'last_name'),
            RgAttribute::AVATAR     => Yii::t('app', 'avatar'),
            RgAttribute::COUNTRY_ID => Yii::t('app', 'country_id'),
            RgAttribute::CITY_ID    => Yii::t('app', 'city_id'),
            RgAttribute::IS_CLOSED  => Yii::t('app', 'Is Closed'),
            RgAttribute::IS_NOTICE  => Yii::t('app', 'Is Notice'),
            RgAttribute::CHILDREN   => Yii::t('app', 'children'),
            RgAttribute::LONGITUDE  => Yii::t('app', 'longitude'),
            RgAttribute::LATITUDE   => Yii::t('app', 'latitude'),
            RgAttribute::LANGUAGE   => Yii::t('app', 'language'),
            RgAttribute::SHORT_LANG => Yii::t('app', 'short_lang'),
            RgAttribute::TIMEZONE   => Yii::t('app', 'timezone'),
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
