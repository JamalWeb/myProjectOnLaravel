<?php

namespace api\modules\v1\models\form;

use api\modules\v1\models\form\base\AbstractUserForm;
use common\components\registry\AttrRegistry;
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
            [
                [
                    AttrRegistry::CITY_ID,
                    AttrRegistry::FIRST_NAME
                ],
                'required'
            ],
            [
                [
                    AttrRegistry::EMAIL,
                    AttrRegistry::PASSWORD
                ],
                'required',
                'on' => self::SCENARIO_CREATE
            ],
            [
                [
                    AttrRegistry::CITY_ID,
                    AttrRegistry::COUNTRY_ID
                ],
                'integer'
            ],
            [
                [
                    AttrRegistry::FIRST_NAME,
                    AttrRegistry::LAST_NAME,
                    AttrRegistry::EMAIL,
                    AttrRegistry::PASSWORD,
                    AttrRegistry::CHILDREN,
                    AttrRegistry::LANGUAGE,
                    AttrRegistry::SHORT_LANG,
                    AttrRegistry::TIMEZONE
                ],
                'string'
            ],
            [
                [AttrRegistry::EMAIL],
                'email'
            ],
            [
                [AttrRegistry::EMAIL],
                function ($attribute) {
                    $user = User::find()->where([AttrRegistry::EMAIL => $this->email])->exists();
                    if ($user) {
                        $this->addError($attribute, 'This email is already in use.');
                    }
                },
                'on' => self::SCENARIO_CREATE
            ],
            [
                [AttrRegistry::PASSWORD],
                'string',
                'min' => 6,
                'max' => 20
            ],
            [
                [
                    AttrRegistry::LONGITUDE,
                    AttrRegistry::LATITUDE
                ],
                'number'
            ],
            [
                [AttrRegistry::AVATAR],
                'image',
                'skipOnEmpty' => true,
                'extensions'  => 'png, jpg, jpeg',
                'maxWidth'    => 500,
                'maxHeight'   => 500,
                'maxSize'     => 5120 * 1024
            ],
            [
                [
                    AttrRegistry::IS_CLOSED,
                    AttrRegistry::IS_NOTICE
                ],
                'boolean'
            ]
        ];
    }
}
