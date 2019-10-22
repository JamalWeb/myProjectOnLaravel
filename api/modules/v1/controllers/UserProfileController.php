<?php
/** @noinspection PhpUnused */

namespace api\modules\v1\controllers;

use api\modules\v1\classes\user\UserProfileApi;

/**
 * @property UserProfileApi $api
 */
class UserProfileController extends BaseController
{
    public $modelName = UserProfileApi::class;
}
