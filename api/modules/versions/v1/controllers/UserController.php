<?php

namespace api\modules\versions\v1\controllers;

class UserController extends BaseController
{
    /**
     * @SWG\Get(path="/v1/user/get",
     *     tags={"User"},
     *     summary="Информация о пользователе",
     *     description="Информация о пользователе",
     *     produces={
     *         "apllication/json",
     *         "multipart/form-data"
     *     },
     *     @SWG\Parameter(
     *         name="post",
     *         in="query",
     *         required=true,
     *         type="integer",
     *         default=1
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
        return 'Arsen';
    }
}
