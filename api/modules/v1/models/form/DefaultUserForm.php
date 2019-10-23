<?php

namespace api\modules\v1\models\form;

use api\modules\v1\models\error\BadRequestHttpException;
use common\models\user\User;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class UserForm
 *
 * @property string       $email      Email
 * @property string       $password   Пароль
 * @property string       $first_name Имя
 * @property string       $last_name  Фамилия
 * @property UploadedFile $avatar     Аватар
 * @property integer      $city_id    Идентификатор города
 * @property bool         $is_closed  Профиль закрыт
 * @property bool         $is_notice  Получать уведомления
 * @property integer      $country_id Идентификатор страны
 * @property float        $longitude  Координаты: Широта
 * @property float        $latitude   Координаты: Долгота
 * @property string       $language   Язык
 * @property string       $short_lang Код языка
 * @property string       $timezone   Часовой пояс
 * @property string       $children   Список детей
 */
class DefaultUserForm extends Model
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $country_id;
    public $city_id;
    public $is_closed;
    public $is_notice;
    public $longitude;
    public $latitude;
    public $language;
    public $short_lang;
    public $timezone;
    public $children;

    /**
     * @var UploadedFile
     */
    public $avatar;

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'first_name'], 'required'],
            [['email', 'password'], 'required', 'on' => self::SCENARIO_CREATE],
            [['city_id', 'country_id'], 'integer'],
            [['first_name', 'last_name', 'email', 'password', 'children', 'language', 'short_lang', 'timezone'], 'string'],
            [['email'], 'email'],
            [
                ['email'], function ($attribute) {
                $user = User::find()->where(['email' => $this->email])->exists();
                if ($user) {
                    $this->addError($attribute, 'This email is already in use.');
                }
            }, 'on' => self::SCENARIO_CREATE
            ],
            [['password'], 'string', 'min' => 6, 'max' => 20],
            [['longitude', 'latitude'], 'number'],
            [
                ['avatar'],
                'image',
                'skipOnEmpty' => true,
                'extensions'  => 'png, jpg, jpeg',
                'maxWidth'    => 500,
                'maxHeight'   => 500,
                'maxSize'     => 5120 * 1024
            ],
            [['is_closed', 'is_notice'], 'boolean']
        ];
    }

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
     * @throws BadRequestHttpException
     */
    public function uploadAvatar(User $user): void
    {
        if (!is_null($this->avatar)) {
            if (!$this->validate('avatar')) {
                throw new BadRequestHttpException($this->getFirstErrors());
            }
            // todo добить загрузку аватарки
            $this->avatar->saveAs('../upload/avatars/' . $this->avatar->baseName . '.' . $this->avatar->extension);
        }
    }
}
