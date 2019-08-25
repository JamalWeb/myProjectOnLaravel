<?php

namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\classes\Api;
use common\models\user\User;
use yii\base\Action;
use yii\web\Controller;

/**
 * @OA\Info(
 *   version="1.0",
 *   title="Документация API",
 *   description="Vorchami",
 *   @OA\Contact(
 *     name="Arsen Abdurashidov",
 *     email="arsen-web@yandex.ru",
 *   ),
 * ),
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      in="header",
 *      name="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 * ),
 * @OA\Server(
 *   url="http://api.project.loc/v1",
 *   description="Локальный сервер",
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
    protected $get = [];

    /** @var array */
    protected $post = [];

    /** @var array */
    protected $headers = [];

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
