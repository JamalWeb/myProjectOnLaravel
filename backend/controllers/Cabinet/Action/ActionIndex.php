<?php


namespace backend\controllers\Cabinet\Action;


use backend\controllers\Base\BaseAction;
use backend\controllers\Cabinet\CabinetController;

/** @property-read CabinetController $controller */
final class ActionIndex extends BaseAction
{
    public function run(): string
    {
        $this->controller->registerMeta('Личный кабинет', '', '');


        return $this->controller->render('index');
    }

}