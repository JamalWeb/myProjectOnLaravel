<?php

namespace backend\Entity\Services\User\Dto;

use common\models\user\User;

class UserLoginDto extends BaseDto
{
    /** @var User */
    public $user;

    /** @var bool */
    public $rememberMe;
}
