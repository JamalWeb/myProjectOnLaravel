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
    /** @var bool */
    public $enableCsrfValidation = false;

    /** @var User */
    protected $user;

    /** @var string */
    protected $modelName = null;

    /** @var Api */
    protected $api;

    /** @var array */
    protected $get;

    /** @var array */
    protected $post;

    /** @var array */
    protected $headers;

    /** @var array */
    protected $response = [];

    public function init(): void
    {
        if (!is_null($this->modelName)) {
            $this->api = new $this->modelName();
        }

        $this->requestInit();
    }

    /**
     * @param Action $action
     * @param mixed  $result
     * @return array|mixed
     */
    public function afterAction($action, $result): array
    {
        parent::afterAction($action, $result);

        return $this->response;
    }

    protected function requestInit(): void
    {
        $request = Yii::$app->request;

        $this->get = $request->get();
        $this->post = $request->post();
        $this->headers = $request->getHeaders();
    }
}
