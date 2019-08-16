<?php

namespace api\modules\v1\controllers;

use api\modules\v1\classes\Api;
use common\models\user\User;
use Yii;
use yii\base\Action;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\web\BadRequestHttpException;
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

    /**
     * Ответ от сервера
     *
     * @var array
     */
    protected $response;

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $my['authenticator'] = [
            'class'       => CompositeAuth::class,
            'except'      => [
                'login'
            ],
            'authMethods' => [
                HttpBearerAuth::class
            ]
        ];

        unset($behaviors['rateLimiter']);

        $behaviors = array_merge($behaviors, $my);

        return $behaviors;
    }

    /**
     * @param $action
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        /**
         * Выполняем родительский beforeAction()
         */
        parent::beforeAction($action);

        /**
         * Если имя модели Api не пустое, то создаем модель
         */
        if (!is_null($this->modelName)) {
            $this->api = new $this->modelName();
        }

        /**
         * Записываем параметры с метода POST
         */
        $this->post = Yii::$app->request->post();

        return true;
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

        return $this->response ?? [];
    }
}
