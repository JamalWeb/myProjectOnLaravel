<?php

namespace api\modules\versions\v1\controllers;

/**
 * Class WebApiController
 */

use Yii;
use Throwable;
use yii\rest\Controller;

use api_web\{
    classes\UserWebApi,
    exceptions\ValidationException
};

use common\models\{
    licenses\License,
    Organization,
    User
};

use yii\filters\{
    ContentNegotiator,
    auth\HttpBearerAuth,
    auth\QueryParamAuth
};

use yii\web\{
    BadRequestHttpException,
    HttpException,
    Response,
    UnauthorizedHttpException
};

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
 *     title="MixCart API WEB - Документация",
 *     description = "Взаимодействие с сервисом MixCart",
 *     version="1.0",
 *     contact={
 *          "name": "MixCart",
 *          "email": "narzyaev@yandex.ru"
 *     }
 * )
 */
class WebApiController extends Controller
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

    /**
     * @throws HttpException
     * @throws Yii\base\ExitException
     * @throws Yii\base\InvalidConfigException
     * @throws Throwable
     * @throws ValidationException
     * @throws UnauthorizedHttpException
     */
    public function init()
    {
        $this->addHeaders();
        $this->checkOptionsHeader();
    }

    /**
     * Добавление заголовкой CORS
     */
    private function addHeaders()
    {
        $headers = Yii::$app->response->headers;
        $headers->add('Access-Control-Allow-Origin', '*');
        $headers->add('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
        $headers->add('Access-Control-Allow-Headers', 'Content-Type, Authorization, GMT');
        $headers->add('Access-Control-Expose-Headers', 'License-Expire, License-Manager-Phone, FileName');
    }

    /**
     * @throws Yii\base\ExitException
     */
    private function checkOptionsHeader()
    {
        if (Yii::$app->request->isOptions) {
            Yii::$app->response->headers->add('Access-Control-Max-Age', 86400);
            Yii::$app->response->statusCode = 200;
            Yii::$app->response->content = ' ';
            Yii::$app->response->send();
            Yii::$app->end(200, Yii::$app->response);
        }
    }
}
