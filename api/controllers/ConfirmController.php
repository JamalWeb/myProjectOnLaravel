<?php

namespace api\controllers;

use yii\web\Controller;

class ConfirmController extends Controller
{
    public function actionEmail($token)
    {
        echo 'Почта подтверждена';
    }
}
