<?php

namespace api\modules\v1\controllers;

use common\models\user\User;
use yii\web\Controller;

/**
 * @SWG\Swagger(
 *     schemes={"https", "http"},
 *     @SWG\SecurityScheme(
 *         securityDefinition="Bearer",
 *         type="apiKey",
 *         name="Authorization",
 *         in="header",
 *         description="Bearer {token}"
 *     ),
 *     basePath="/"
 * )
 * @SWG\Info(
 *     title="Vorchami Project-name - Документация",
 *     description = "Взаимодействие с сервисом project-name",
 *     version="1.0",
 *     contact={
 *          "name": "Arsen",
 *          "email": "arsen-web@yandex.ru"
 *     }
 * )
 */
class BaseController extends Controller
{
    /**
     * @var User $user
     */
    protected $user;

    /**
     * Description
     *
     * @var bool
     */
    public $enableCsrfValidation = false;

    /**
     * Класс экземпляр которого поместим в $this->classWebApi
     *  Например ChatWebApi::class
     */
    public $modelName = null;

    /**
     * Экземпляр класса из $this->className
     */
    protected $api;

    public function beforeAction($action)
    {

        if (isset($this->modelName) && !is_null($this->modelName)) {
            $this->api = new $this->modelName();
        }
        parent::beforeAction($action);

        return true;
    }

}
