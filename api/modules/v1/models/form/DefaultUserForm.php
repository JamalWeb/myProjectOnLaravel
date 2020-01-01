<?php

namespace api\modules\v1\models\form;

use api\modules\v1\models\form\base\AbstractUserForm;
use common\components\registry\RgAttribute;
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
                    RgAttribute::CITY_ID,
                    RgAttribute::FIRST_NAME
                ],
                'required'
            ],
            [
                [
                    RgAttribute::EMAIL,
                    RgAttribute::PASSWORD
                ],
                'required'
            ],
            [
                [
                    RgAttribute::CITY_ID
                ],
                'integer'
            ],
            [
                [
                    RgAttribute::FIRST_NAME,
                    RgAttribute::LAST_NAME,
                    RgAttribute::EMAIL,
                    RgAttribute::PASSWORD,
                    RgAttribute::CHILDREN,
                    RgAttribute::LANGUAGE,
                    RgAttribute::SHORT_LANG,
                    RgAttribute::TIMEZONE
                ],
                'string'
            ],
            [
                [
                    RgAttribute::EMAIL
                ],
                'email'
            ],
            [
                [
                    RgAttribute::EMAIL
                ],
                function ($attribute) {
                    $user = User::find()
                        ->where(
                            [
                                RgAttribute::EMAIL => $this->email
                            ]
                        )
                        ->exists();
                    if ($user) {
                        $this->addError($attribute, 'This email is already in use.');
                    }
                }
            ],
            [
                [
                    RgAttribute::PASSWORD
                ],
                'string',
                'min' => 6,
                'max' => 20
            ],
            [
                [
                    RgAttribute::LONGITUDE,
                    RgAttribute::LATITUDE
                ],
                'number'
            ],
            [
                [
                    RgAttribute::AVATAR
                ],
                'image',
                'skipOnEmpty' => true,
                'extensions'  => 'png, jpg, jpeg',
                'maxWidth'    => 500,
                'maxHeight'   => 500,
                'maxSize'     => 5120 * 1024
            ],
            [
                [
                    RgAttribute::IS_CLOSED,
                    RgAttribute::IS_NOTICE
                ],
                'boolean'
            ]
        ];
    }
}
