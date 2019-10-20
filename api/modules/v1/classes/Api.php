<?php

namespace api\modules\v1\classes;

use common\models\user\User;
use Yii;

/**
 * Class Api
 */
class Api
{
    /**
     * @var User
     */
    public $user;

    public function __construct()
    {
        $this->user = Yii::$app->user->identity;
    }
}
