<?php

namespace backend\models\Cabinet;

use backend\Entity\Services\User\Dto\UserProfileDto;
use common\components\ArrayHelper;
use common\components\PasswordHelper;
use common\models\user\UserGender;
use Exception;
use yii\base\Model;
use yii\web\User;

/**
 * @property mixed $gender
 * @property UserProfileDto $dto
 */
class ProfileForm extends Model
{
    public $firstName;
    public $lastName;
    public $patronymic;
    public $avatar;
    public $phoneNumber;
    public $address;
    public $genderId;
    public $username;
    public $email;
    public $createdAt;
    public $updatedAt;
    public $role;
    public $type;

    /** @var User */
    private $user;
    public $currentPassword;
    public $newPassword;

    /**
     * ProfileForm constructor.
     * @param User $user
     * @param array $config
     */
    public function __construct(User $user, $config = [])
    {
        parent::__construct($config);
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'firstName',
                    'lastName',
                    'patronymic',
                    'address',
                    'username',
                ],
                'string',
            ],
            [
                [
                    'firstName',
                    'lastName',
                    'patronymic',
                    'address',
                    'username',
                ],
                'filter',
                'filter' => 'trim',
            ],
            [
                'email',
                'email',
            ],
            [
                'phoneNumber',
                'string',
            ],
            [

                'phoneNumber',
                'match',
                'pattern' => '/^(8)[(](\d{3})[)](\d{3})[-](\d{2})[-](\d{2})/',
                'message' => 'Телефона, должно быть в формате 8(XXX)XXX-XX-XX',

            ],
            ['genderId', 'integer'],
            [['currentPassword', 'newPassword'], 'validateCurrentPassword'],

        ];
    }

    public function validateCurrentPassword($attribute): void
    {
        if (empty($this->currentPassword) && !empty($this->newPassword)) {
            $this->addErrors(
                [
                    'currentPassword' => 'Введите текущий пароль',
                    'newPassword'     => 'Введите текущий пароль',
                ]
            );
        }

        if (!empty($this->currentPassword)) {
            $result = $this->user->identity->validatePassword($this->currentPassword);
            if (!$result) {
                $this->addError($attribute, 'Текущий пароль не совпадает');
            }
        }
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'firstName'       => 'Имя',
            'lastName'        => 'Фамилия',
            'patronymic'      => 'Отчество',
            'phoneNumber'     => 'Номер телефона',
            'address'         => 'Адрес',
            'genderId'        => 'Пол',
            'username'        => 'Имя пользователя',
            'email'           => 'Email',
            'createdAt'       => 'Дата регистраций',
            'role'            => 'Роль',
            'type'            => 'Тип',
            'currentPassword' => 'Текущий пароль',
            'newPassword'     => 'Новый пароль',
        ];
    }

    /**
     * @return array
     */
    public static function getGenders(): array
    {
        $genders = UserGender::find()->asArray()->all();

        return ArrayHelper::map($genders, 'id', 'name');
    }

    /**
     * @return UserProfileDto
     * @throws Exception
     */
    public function getDto(): UserProfileDto
    {
        $dto = new UserProfileDto();
        $dto->userId = $this->user->identity->getId();
        $dto->username = $this->username;
        $dto->firstName = $this->firstName;
        $dto->lastName = $this->lastName;
        $dto->patronymic = $this->patronymic;
        $dto->phoneNumber = $this->phoneNumber;
        $dto->genderId = $this->genderId;
        $dto->email = $this->email;
        $dto->address = $this->address;
        $dto->newPassword = !empty($this->newPassword) ? PasswordHelper::encrypt(
            $this->newPassword
        ) : $this->user->identity->password;

        return $dto;
    }
}
