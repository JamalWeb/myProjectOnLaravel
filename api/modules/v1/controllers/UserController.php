<?php
/** @noinspection PhpUnused */

namespace api\modules\v1\controllers;

use api\modules\v1\classes\UserApi;
use Exception;

/**
 * @property UserApi $api
 */
class UserController extends BaseController
{
    public $modelName = UserApi::class;

    /**
     * @OA\Get(
     *   path="/user/get-genders",
     *   summary="Список гендерных принадлежностей",
     *   tags={"Пользователь | User"},
     *   @OA\Response(
     *     response=200,
     *     description="success",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         example={
     *           {
     *              "id": 1,
     *              "name": "Male"
     *           },
     *           {
     *              "id": 2,
     *              "name": "Female"
     *           }
     *         }
     *       ),
     *     ),
     *   ),
     * )
     */
    public function actionGetGenders(): array
    {
        return $this->api->getGender();
    }

    /**
     * @OA\Post(
     *   path="/user/registration-user",
     *   summary="Регистрация нового пользователя",
     *   tags={"Пользователь | User"},
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="email",
     *           description="Email",
     *           type="string",
     *           example="neo@neo.com"
     *         ),
     *         @OA\Property(
     *           property="password",
     *           description="Пароль",
     *           type="string",
     *           example="vorchami"
     *         ),
     *         @OA\Property(
     *           property="country_id",
     *           description="Идентификатор страны",
     *           type="integer",
     *           example=1
     *         ),
     *         @OA\Property(
     *           property="city_id",
     *           description="Идентификатор города",
     *           type="integer",
     *           example=1
     *         ),
     *         @OA\Property(
     *           property="first_name",
     *           description="Имя",
     *           type="string",
     *           example="Иван"
     *         ),
     *         @OA\Property(
     *           property="last_name",
     *           description="Фамилия",
     *           type="string",
     *           example="Иванов"
     *         ),
     *         @OA\Property(
     *           property="language",
     *           description="Язык",
     *           type="string",
     *           example="Russian"
     *         ),
     *         @OA\Property(
     *           property="short_lang",
     *           description="Код языка",
     *           type="string",
     *           example="ru-RU"
     *         ),
     *         @OA\Property(
     *           property="timezone",
     *           description="Часовой пояс",
     *           type="string",
     *           example="Europe/Moscow"
     *         ),
     *         @OA\Property(
     *           property="longitude",
     *           description="Координаты: широта",
     *           type="number",
     *           example="55.7522"
     *         ),
     *         @OA\Property(
     *           property="latitude",
     *           description="Координаты: долгота",
     *           type="number",
     *           example="37.6156"
     *         ),
     *         @OA\Property(
     *           property="children",
     *           description="Список детей",
     *           type="object",
     *           example={
     *             {
     *               "age": 5,
     *               "gender_id": 1,
     *             },
     *             {
     *               "age": 11,
     *               "gender_id": 2,
     *             }
     *           }
     *         ),
     *         required={"email", "password"}
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="success",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         example={
     *           "name": 5,
     *           "email": "mail@yandex.ru",
     *           "phone": "+79999999999",
     *           "name": "Годный Старец",
     *           "role_id": 3,
     *           "role": "Руководитель"
     *         }
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="BadRequestHttpException"
     *   )
     * )
     * @throws Exception
     */
    public function actionRegistrationUser(): array
    {
        return $this->api->registrationUser($this->post);
    }

    /**
     * @OA\Post(
     *   path="/user/registration-business-user",
     *   summary="Регистрация нового бизнес-пользователя",
     *   tags={"Пользователь | User"},
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="email",
     *           description="Email",
     *           type="string",
     *           example="neo@neo.com"
     *         ),
     *         @OA\Property(
     *           property="password",
     *           description="Пароль",
     *           type="string",
     *           example="vorchami"
     *         ),
     *         @OA\Property(
     *           property="country_id",
     *           description="Идентификатор страны",
     *           type="integer",
     *           example=1
     *         ),
     *         @OA\Property(
     *           property="city_id",
     *           description="Идентификатор города",
     *           type="integer",
     *           example=1
     *         ),
     *         @OA\Property(
     *           property="name",
     *           description="Имя пользователя",
     *           type="string",
     *           example="Иван"
     *         ),
     *         @OA\Property(
     *           property="longitude",
     *           description="Координаты: широта",
     *           type="number",
     *           example="55.7522"
     *         ),
     *         @OA\Property(
     *           property="children",
     *           description="Список детей",
     *           type="object",
     *           example={
     *             {
     *               "age": 5,
     *               "gender_id": 1,
     *             },
     *             {
     *               "age": 11,
     *               "gender_id": 2,
     *             }
     *           }
     *         ),
     *         required={"email", "password"}
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="success",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         example={
     *           "name": 5,
     *           "email": "mail@yandex.ru",
     *           "phone": "+79999999999",
     *           "name": "Годный Старец",
     *           "role_id": 3,
     *           "role": "Руководитель"
     *         }
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="BadRequestHttpException"
     *   )
     * )
     * @throws Exception
     */
    public function actionRegistrationBusinessUser()
    {
        return $this->api->registrationBusinessUser();
    }

    /**
     * @OA\Post(
     *   path="/user/login",
     *   summary="Авторизация",
     *   tags={"Пользователь | User"},
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="email",
     *           type="string",
     *           example="neo@neo.com"
     *         ),
     *         @OA\Property(
     *           property="password",
     *           type="string",
     *           example="neo"
     *         ),
     *         required={"email", "password"}
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="success",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         example={
     *           "auth_token": "slHuh1vS-P74LGIE54R8qvY52ncL0kRh",
     *           "reset_auth_token": "slHuh1vS-P74LGIE54R8qvY52ncL0kRh",
     *         }
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="UnauthorizedHttpException"
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="BadRequestHttpException"
     *   )
     * )
     * @throws Exception
     */
    public function actionLogin()
    {
        return $this->api->login($this->post);
    }

    /**
     * @OA\Post(
     *   path="/user/reset-auth-token",
     *   summary="Сброс токена аутентификации",
     *   tags={"Пользователь | User"},
     *   @OA\Parameter(
     *     in="header",
     *     name="reset-auth-token",
     *     @OA\Schema(
     *       type="string",
     *       example="slHuh1vS-P74LGIE54R8qvY52ncL0kRh"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="success",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         example={
     *           "auth_token": "slHuh1vS-P74LGIE54R8qvY52ncL0kRh",
     *           "reset_auth_token": "slHuh1vS-P74LGIE54R8qvY52ncL0kRh",
     *         }
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="UnauthorizedHttpException"
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="BadRequestHttpException"
     *   )
     * )
     * @throws Exception
     */
    public function actionResetAuthToken()
    {
        return $this->api->resetAuthToken($this->headers);
    }
}
