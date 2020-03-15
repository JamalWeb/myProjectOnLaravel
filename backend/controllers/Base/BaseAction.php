<?php

namespace backend\controllers\Base;

use Yii;
use yii\base\Action;

class BaseAction extends Action
{
    /** @var string */
    public $appName;

    public function init()
    {
        $this->appName = Yii::$app->name;
    }
}
