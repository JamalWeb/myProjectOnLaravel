<?php

namespace backend\controllers\Base;

use common\models\user\User;
use Yii;
use yii\web\Controller;

/**
 * @property-read User $authorizedUser
 */
class BaseController extends Controller
{
    public $authorizedUser;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->authorizedUser = Yii::$app->user->identity;
    }

    public function getViewPath(): string
    {
        return $this->module->getBasePath(
            ) . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $this->id . DIRECTORY_SEPARATOR . 'View';
    }
}
