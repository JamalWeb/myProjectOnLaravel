<?php
/** @noinspection PhpUnused */

namespace api\modules\v1\controllers;

use api\modules\v1\classes\UserProfileApi;
use api\modules\v1\models\error\BadRequestHttpException;

/**
 * @property UserProfileApi $api
 */
class UserProfileController extends BaseController
{
    public $modelName = UserProfileApi::class;
}
