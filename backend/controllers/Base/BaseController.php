<?php

namespace backend\controllers\Base;

use yii\web\Controller;

class BaseController extends Controller
{
    public function getViewPath(): string
    {
        return $this->module->getBasePath(
            ) . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $this->id . DIRECTORY_SEPARATOR . 'views';
    }
}
