<?php

namespace api\modules\v1\models\form;

use common\components\ArrayHelper;
use common\components\PassHelper;
use common\models\user\Role;
use common\models\user\User;
use common\models\user\UserType;
use Exception;
use Yii;
use yii\base\Model;

/**
 * Class UserForm
 *
 * @property integer $city_id  - Идентификатор города
 * @property string  $name     - Имя пользователя
 * @property string  $email    - Email
 * @property string  $password - Пароль
 * @property string  $children - Список детей
 * @package api\modules\v1\models\form
 */
class UserForm extends Model
{
    public $city_id;
    public $name;
    public $email;
    public $password;
    public $children;

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'name', 'email', 'password'], 'required'],
            [['city_id'], 'integer'],
            [['name', 'email', 'password', 'children'], 'string'],
            [['email'], 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'city_id'  => Yii::t('api', 'city_id'),
            'name'     => Yii::t('api', 'name'),
            'email'    => Yii::t('api', 'email'),
            'password' => Yii::t('api', 'password'),
            'children' => Yii::t('api', 'children'),
        ];
    }

    /**
     * Создание аккаунта
     *
     * @throws Exception
     */
    public function create()
    {
        if (!empty($this->children)) {
            $this->children = ArrayHelper::jsonToArray($this->children);
        }

        $user = new User([
            'email'        => $this->email,
            'role_id'      => Role::ROLE_USER,
            'status'       => User::STATUS_ACTIVE,
            'password'     => (new PassHelper())->encrypt($this->password)
        ]);
    }
}
