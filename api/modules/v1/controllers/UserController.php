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
     *   path="/user/registration-default-user",
     *   summary="Регистрация обычного пользователя",
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
     *             "id": 8,
     *             "email": "default_user@mamppa.com",
     *             "type": {
     *                 "id": 3,
     *                 "name": "User",
     *                 "desc": "Обычный пользователь"
     *             },
     *             "role": {
     *                 "id": 3,
     *                 "name": "User",
     *                 "desc": "Обычный пользователь"
     *             },
     *             "status": {
     *                 "id": 1,
     *                 "name": "Активен"
     *             },
     *             "banned": {
     *                 "is_banned": false,
     *                 "banned_reason": null,
     *                 "banned_at": null
     *             },
     *             "profile": {
     *                 "first_name": "Иван",
     *                 "last_name": "Иванов",
     *                 "phone_number": null,
     *                 "address": null,
     *                 "about": null,
     *                 "country_id": {
     *                     "id": 1,
     *                     "name": "Russia"
     *                 },
     *                 "city_id": {
     *                     "id": 1,
     *                     "name": "Moscow"
     *                 },
     *                 "longitude": "55.7522",
     *                 "latitude": "55.7522",
     *                 "language": "Russian",
     *                 "short_lang": "ru-RU",
     *                 "timezone": "Europe/Moscow"
     *             },
     *             "children": {
     *                 {
     *                     "id": 7,
     *                     "age": 5,
     *                     "gender": {
     *                         "id": 1,
     *                         "name": "Male"
     *                     }
     *                 },
     *                 {
     *                     "id": 8,
     *                     "age": 11,
     *                     "gender": {
     *                         "id": 2,
     *                         "name": "Female"
     *                     }
     *                 }
     *              },
     *             "created_at": "2019-10-19 19:23:40"
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
    public function actionRegistrationDefaultUser(): array
    {
        return $this->api->registrationDefaultUser($this->post);
    }

    /**
     * @OA\Post(
     *   path="/user/registration-business-user",
     *   summary="Регистрация бизнес-пользователя",
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
     *           property="first_name",
     *           description="Название",
     *           type="string",
     *           example="vorchami"
     *         ),
     *         @OA\Property(
     *           property="phone_number",
     *           description="Телефонный номер",
     *           type="string",
     *           example="79886337711"
     *         ),
     *         @OA\Property(
     *           property="address",
     *           description="Адрес",
     *           type="string",
     *           example="г.Москва ул.Гурьянова д.5 кв.129"
     *         ),
     *         @OA\Property(
     *           property="about",
     *           description="Описание",
     *           type="string",
     *           example="Бомбочка"
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
     *           property="longitude",
     *           description="Координаты: широта",
     *           type="number",
     *           example="55.7522"
     *         ),
     *         @OA\Property(
     *           property="latitude",
     *           description="Координаты: долгота",
     *           type="number",
     *           example="55.7522"
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
     *         required={
     *             "email",
     *             "password",
     *             "city_id",
     *             "first_name",
     *             "phone_number",
     *             "about"
     *         }
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
     *             "id": 9,
     *             "email": "neo@neo.com",
     *             "type": {
     *                 "id": 3,
     *                 "name": "Business",
     *                 "desc": "Бизнес пользователь"
     *             },
     *             "role": {
     *                 "id": 3,
     *                 "name": "Business",
     *                 "desc": "Бизнес пользователь"
     *             },
     *             "status": {
     *                 "id": 1,
     *                 "name": "Активен"
     *             },
     *             "banned": {
     *                 "is_banned": false,
     *                 "banned_reason": null,
     *                 "banned_at": null
     *             },
     *             "profile": {
     *                 "first_name": "vorchami",
     *                 "last_name": null,
     *                 "phone_number": "79886337711",
     *                 "address": "г.Москва ул.Гурьянова д.5 кв.129",
     *                 "about": "Бомбочка",
     *                 "country_id": {
     *                     "id": 1,
     *                     "name": "Russia"
     *                 },
     *                 "city_id": {
     *                     "id": 1,
     *                     "name": "Moscow"
     *                 },
     *                 "longitude": "55.7522",
     *                 "latitude": "55.7522",
     *                 "language": "Russian",
     *                 "short_lang": "ru-RU",
     *                 "timezone": "Europe/Moscow"
     *             },
     *             "children": {},
     *             "created_at": "2019-10-19 19:23:40"
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
        return $this->api->registrationBusinessUser($this->post);
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