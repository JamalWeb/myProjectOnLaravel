<?php

namespace backend\Entity\Services\User\Dto;

class UserCreateDto extends BaseDto
{
    public $email;
    public $role;
    public $firstName;
    public $userName;
    public $typeId;
    public $password;
    public $authKey;
    public $passwordResetToken;
    public $statusId;
    public $genderId;
    public $roleId;
    public $cityId;
    public $countryId;
    public $accessToken;
    public $passwordUser;
}
