<?php

namespace backend\models\Cabinet;

use backend\Entity\Services\User\Dto\UserProfileDto;
use common\components\ArrayHelper;
use common\models\user\UserGender;
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
    public $genderName;
    public $genderId;

    public $username;
    public $email;
    public $createdAt;
    public $updatedAt;
    public $role;
    public $type;

    /** @var User */
    private $user;

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
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'firstName'   => 'Имя',
            'lastName'    => 'Фамилия',
            'patronymic'  => 'Отчество',
            'phoneNumber' => 'Номер телефона',
            'address'     => 'Адрес',
            'genderId'    => 'Пол',
            'username'    => 'Имя пользователя',
            'email'       => 'Email',
            'createdAt'   => 'Дата регистраций',
            'role'        => 'Роль',
            'type'        => 'Тип',
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

        return $dto;
    }
}
