<?php

namespace backend\Entity\Services\User\Dto;

use backend\models\Cabinet\ProfileForm;

/**
 * @see ProfileForm
 */
class UserProfileDto extends BaseDto
{
    public $userId;
    public $firstName;
    public $lastName;
    public $patronymic;
    public $phoneNumber;
    public $address;
    public $genderId;
    public $username;
    public $email;
    public $avatar;
    public $newPassword;
}
