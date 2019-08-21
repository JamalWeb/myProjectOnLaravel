<?php

namespace api\modules\v1\controllers;

use api\modules\v1\classes\Api;
use common\models\user\User;
use Yii;
use yii\base\Action;
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
     * Проверка что запрос с методом POST был выполнен на сервере
     *
     * @var bool
     */
    public $enableCsrfValidation = false;

    /**
     * Текущий пользователь
     *
     * @var User
     */
    protected $user;

    /**
     * Имя модели Api
     * Например UserApi::class
     *
     * @var string
     */
    protected $modelName = null;

    /**
     * Экземпляр класса из $this->modelName
     *
     * @var Api
     */
    protected $api;

    /**
     * Параметры метода POST
     *
     * @var array
     */
    protected $post;

    protected $headers;

    /**
     * Ответ от сервера
     *
     * @var array
     */
    protected $response = [];

    public function init()
    {
        if (!is_null($this->modelName)) {
            $this->api = new $this->modelName();
        }

        $this->post = Yii::$app->request->post();
        $this->headers = Yii::$app->request->getHeaders();
    }

    /**
     * Методы который вызывается после методов action*
     *
     * @param Action $action
     * @param mixed  $result
     * @return array|mixed
     */
    public function afterAction($action, $result)
    {
        parent::afterAction($action, $result);

        return $this->response;
    }
}
