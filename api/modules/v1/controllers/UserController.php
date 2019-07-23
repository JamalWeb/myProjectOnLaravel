<?php

namespace api\modules\v1\controllers;

use api\modules\v1\classes\UserApi;
use Exception;

/**
 * * @property UserApi $api
 */
class UserController extends BaseController
{
    public $modelName = UserApi::class;

    /**
     * @SWG\POST(path="/v1/user/registration-user",
     *     tags={"Пользователь | User"},
     *     summary="Регистрация нового пользователя",
     *     description="Регистрация нового пользователя",
     *     consumes={"multipart/form-data"},
     *     produces={"text/plain, application/json"},
     *     @SWG\Parameter(
     *         name="city_id",
     *         description="Идентификатор города",
     *         in="formData",
     *         required=false,
     *         type="integer",
     *         default=1
     *     ),
     *     @SWG\Parameter(
     *         name="name",
     *         description="Имя пользователя",
     *         in="formData",
     *         required=false,
     *         type="string",
     *         default="Иван"
     *     ),
     *     @SWG\Parameter(
     *         name="email",
     *         description="Электронная почта",
     *         in="formData",
     *         required=false,
     *         type="string",
     *         default="user@example.ru"
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         description="Пароль",
     *         in="formData",
     *         required=false,
     *         type="string",
     *         default="vorchami"
     *     ),
     *     @SWG\Parameter(
     *         name="children",
     *         description="Список детей (ключи обернуть в ковычки)",
     *         in="formData",
     *         required=false,
     *         type="string",
     *         default="[{age:11, gender: М}, {age:11, gender: Ж}]"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "success",
     *         @SWG\Schema(
     *            default={
     *              "name": 5,
     *              "email": "mail@yandex.ru",
     *              "phone": "+79999999999",
     *              "name": "Годный Старец",
     *              "role_id": 3,
     *              "role": "Руководитель"
     *            }
     *         )
     *     ),
     *     @SWG\Response(
     *         response = 400,
     *         description = "BadRequestHttpException"
     *     )
     * )
     * @throws Exception
     */
    public function actionRegistrationUser()
    {
        $this->response = $this->api->registrationUser($this->post);
    }

    /**
     * @SWG\POST(path="/v1/user/registration-business",
     *     tags={"Пользователь | User"},
     *     summary="Регистрация нового бизнеса",
     *     description="Регистрация нового бизнеса",
     *     consumes={"multipart/form-data"},
     *     produces={"text/plain, application/json"},
     *     @SWG\Parameter(
     *         name="city_id",
     *         description="Идентификатор города",
     *         in="formData",
     *         required=false,
     *         type="integer",
     *         default=1
     *     ),
     *     @SWG\Parameter(
     *         name="name",
     *         description="Название бизнеса",
     *         in="formData",
     *         required=false,
     *         type="string",
     *         default="Иван"
     *     ),
     *     @SWG\Parameter(
     *         name="email",
     *         description="Электронная почта",
     *         in="formData",
     *         required=false,
     *         type="string",
     *         default="user@example.ru"
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         description="Пароль",
     *         in="formData",
     *         required=false,
     *         type="string",
     *         default="vorchami"
     *     ),
     *     @SWG\Parameter(
     *         name="address",
     *         description="Адрес",
     *         in="formData",
     *         required=false,
     *         type="string",
     *         default="ул.Гурьянова д.5"
     *     ),
     *     @SWG\Parameter(
     *         name="phone",
     *         description="Номер телефона",
     *         in="formData",
     *         required=false,
     *         type="string",
     *         default="79881112233"
     *     ),
     *     @SWG\Parameter(
     *         name="about",
     *         description="Описание",
     *         in="formData",
     *         required=false,
     *         type="string",
     *         default="Описание бизнеса"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "success",
     *         @SWG\Schema(
     *            default={
     *              "name": 5,
     *              "email": "mail@yandex.ru",
     *              "phone": "+79999999999",
     *              "name": "Годный Старец",
     *              "role_id": 3,
     *              "role": "Руководитель"
     *            }
     *         )
     *     ),
     *     @SWG\Response(
     *         response = 400,
     *         description = "BadRequestHttpException"
     *     )
     * )
     * @throws Exception
     */
    public function actionRegistrationBusiness()
    {
        $this->response = $this->api->registrationBusiness();
    }
}
