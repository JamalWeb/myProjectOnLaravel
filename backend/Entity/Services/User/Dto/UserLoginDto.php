<?php

namespace backend\Entity\Services\User\Dto;

use common\models\user\User;

class UserLoginDto
{
    /** @var User */
    public $user;

    /** @var bool */
    public $rememberMe;
}
