<?php

namespace api\modules\versions\v1\controllers;

use common\models\User;
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
     * @var array $request
     */
    protected $request;
    /**
     * @var array $response
     */
    protected $response;

    /**
     * @var array
     */
    public $not_log_actions = [];

    /**
     * @var integer id Service
     */
    public $license_service_id = 0;

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
    public $className = null;

    /**
     * Экземпляр класса из $this->className
     */
    protected $classWebApi;
}
