<?php


namespace backend\models\User;


use backend\Entity\Services\User\Dto\UserCreateDto;
use common\components\ArrayHelper;
use common\components\PasswordHelper;
use common\components\registry\RgUser;
use common\helpers\UserPermissionsHelper;
use common\models\user\User;
use common\models\user\UserGender;
use Yii;
use yii\base\Model;

class UserForm extends Model
{
    public $email;
    public $role;
    public $firstName;
    public $userName;
    public $typeID = RgUser::TYPE_SYSTEM;
    public $statusID = RgUser::STATUS_UNCONFIRMED_EMAIL;
    public $genderId;
    public $cityId = 1;
    public $countryId;

    public static $roles = [
        'Admin'     => 'Администратор',
        'Moderator' => 'Модератор',
    ];

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                'email',
                'email',
            ],
            [
                'email',
                function ($attribute) {
                    if (User::find()->where(['email' => $this->email])->exists()) {
                        $this->addError($attribute, 'Пользователь с таким email уже существует');
                    }
                },
            ],
            [
                'role',
                'string',
            ],
            [
                ['firstName'],
                'string',
                'max' => 50,
            ],
            ['genderId', 'integer'],
        ];
    }

    /**
     * @return array
     */
    public static function getRoles(): array
    {
        return self::$roles;
    }

    /**
     * @return array
     */
    public static function getGenders(): array
    {
        return ArrayHelper::map(UserGender::find()->asArray()->all(), 'id', 'name');
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'role'      => 'Роль',
            'email'     => 'Email',
            'firstName' => 'Имя',
            'username'  => 'Username в системе',
            'genderId'  => 'Пол',
        ];
    }

    public function getDto(): UserCreateDto
    {
        $randomPassword = Yii::$app->security->generateRandomString(10);

        $role = RgUser::ROLE_DEFAULT;
        if ($this->role === UserPermissionsHelper::ROLE_MODERATOR) {
            $role = RgUser::ROLE_MODERATOR;
        }
        if ($this->role === UserPermissionsHelper::ROLE_ADMIN) {
            $role = RgUser::ROLE_ADMIN;
        }

        $dto = new UserCreateDto();
        $dto->email = $this->email;
        $dto->firstName = $this->firstName;
        $dto->role = $this->role;
        $dto->userName = $this->userName;
        $dto->typeId = $this->typeID;
        $dto->statusId = $this->statusID;
        $dto->password = PasswordHelper::encrypt($randomPassword);
        $dto->passwordUser = $randomPassword;
        $dto->authKey = Yii::$app->security->generateRandomString();
        $dto->genderId = $this->genderId;
        $dto->roleId = $role;
        $dto->cityId = $this->cityId;
        $dto->countryId = $this->countryId;
        $dto->accessToken = Yii::$app->security->generateRandomString(34);

        return $dto;
    }
}
