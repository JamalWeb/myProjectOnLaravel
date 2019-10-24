<?php

namespace api\modules\v1\models\form;

use api\modules\v1\models\form\base\AbstractUserForm;
use common\models\user\User;
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
class DefaultUserForm extends AbstractUserForm
{
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
}
