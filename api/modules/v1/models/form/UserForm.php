<?php

namespace api\modules\v1\models\form;

use yii\base\Model;

/**
 * Class UserForm
 *
 * @package api\modules\v1\models\form
 */
class UserForm extends Model
{
    /**
     * Идентификатор города
     *
     * @var int
     */
    public $city_id;

    /**
     * Имя пользователя
     *
     * @var string
     */
    public $name;

    /**
     * Email
     *
     * @var string
     */
    public $email;

    /**
     * Пароль
     *
     * @var string
     */
    public $password;

    /**
     * Список детей
     *
     * @var array
     */
    public $children = [];

    public function rules()
    {
        return [
            [['city_id', 'name', 'email', 'password'], 'required'],
            [['city_id'], 'integer'],
            [['name', 'email', 'password'], 'string'],
        ];
    }
}
