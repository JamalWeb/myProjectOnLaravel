<?php

namespace api\modules\versions\v1\controllers;

use Yii;
use yii\web\Response;

class UserController extends BaseController
{
    /**
     * @SWG\Post(path="/v1/user/get",
     *     tags={"User"},
     *     summary="Информация о пользователе",
     *     description="Информация о пользователе",
     *     produces={
     *         "apllication/json",
     *         "multipart/form-data"
     *     },
     *     @SWG\Parameter(
     *         name="post",
     *         in="body",
     *         required=true,
     *         @SWG\Schema (
     *              @SWG\Property(
     *                  property="request",
     *                  type="object",
     *                  default={"id":1, "email":"neo@neo.com"}
     *              )
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="post1",
     *         in="body",
     *         required=true,
     *         @SWG\Schema (
     *              @SWG\Property(
     *                  property="request",
     *                  type="object",
     *                  default={"id":1, "email":"neo@neo.com"}
     *              )
     *         )
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "success",
     *         @SWG\Schema(
     *            default={
     *                   "id": 5,
     *                   "email": "mail@yandex.ru",
     *                   "phone": "+79999999999",
     *                   "name": "Годный Старец",
     *                   "role_id": 3,
     *                   "role": "Руководитель"
     *               }
     *         )
     *     ),
     *     @SWG\Response(
     *         response = 400,
     *         description = "BadRequestHttpException"
     *     ),
     *     @SWG\Response(
     *         response = 401,
     *         description = "UnauthorizedHttpException"
     *     )
     * )
     * @throws \Exception
     */
    public function actionGet()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return 'Arsen';
    }
}
