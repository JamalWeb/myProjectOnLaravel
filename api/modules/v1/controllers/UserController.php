<?php

/** @noinspection PhpUnused */

namespace api\modules\v1\controllers;

use api\modules\v1\classes\UserApi;
use api\modules\v1\models\error\BadRequestHttpException;
use Exception;

/**
 * @property UserApi $api
 */
class UserController extends BaseController
{
    public $modelName = UserApi::class;
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
     *           type="email",
     *           example="neo@neo.com"
     *         ),
     *         @OA\Property(
     *           property="password",
     *           type="string",
     *           example="vorchami"
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

    /**
     * @OA\Get(
     *   path="/user/get-gender-list",
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
    public function actionGetGenderList(): array
    {
        return $this->api->getGenderList();
    }

    /**
     * @OA\Post(
     *   path="/user/registration-default",
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
     *           property="city_id",
     *           description="Идентификатор города",
     *           type="integer",
     *           example=1
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
     *               "gender_id": 1
     *             },
     *             {
     *               "age": 11,
     *               "gender_id": 2
     *             }
     *           }
     *         ),
     *         required={
     *             "email",
     *             "password",
     *             "city_id",
     *             "first_name"
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
     *           "id": 4,
     *           "email": "neo4@neo.com",
     *           "access": {
     *             "auth_token": "3jGgrsbY9WfZe_6lzJVHLFrT4KPkRzYhEB",
     *             "reset_auth_token": "nXj35NGV6bTxK6cOrIdWaEjrHAlbW6DR89"
     *           },
     *           "profile": {
     *             "first_name": "Иван",
     *             "last_name": "Иванов",
     *             "phone_number": null,
     *             "address": null,
     *             "about": null,
     *             "country": null,
     *             "city": {
     *               "id": 1,
     *               "name": "Moscow"
     *             },
     *             "children": {
     *               {
     *                 "id": 5,
     *                 "age": 5,
     *                 "gender": {
     *                   "id": 1,
     *                   "name": "Male"
     *                 }
     *               },
     *               {
     *                 "id": 6,
     *                 "age": 11,
     *                 "gender": {
     *                   "id": 2,
     *                   "name": "Female"
     *                 }
     *               }
     *             },
     *             "type": {
     *                 "id": 2,
     *                 "name": "User",
     *                 "description": "Обычный пользователь"
     *             },
     *             "longitude": "55.7522",
     *             "latitude": "37.6156",
     *             "language": "Russian",
     *             "short_lang": "ru-RU",
     *             "timezone": "Europe/Moscow"
     *           },
     *           "banned": {
     *             "is_banned": false,
     *             "banned_reason": null,
     *             "banned_at": null
     *           },
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
    public function actionRegistrationDefault(): array
    {
        return $this->api->createDefault($this->post);
    }

    /**
     * @OA\Post(
     *   path="/user/registration-business",
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
     *           property="city_id",
     *           description="Идентификатор города",
     *           type="integer",
     *           example=1
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
     *           "id": 9,
     *           "email": "neo@neo.com",
     *           "access": {
     *             "auth_token": "3jGgrsbY9WfZe_6lzJVHLFrT4KPkRzYhEB",
     *             "reset_auth_token": "nXj35NGV6bTxK6cOrIdWaEjrHAlbW6DR89"
     *           },
     *           "profile": {
     *             "first_name": "vorchami",
     *             "last_name": null,
     *             "phone_number": "79886337711",
     *             "address": "г.Москва ул.Гурьянова д.5 кв.129",
     *             "about": "Бомбочка",
     *             "country": null,
     *             "city": {
     *                 "id": 1,
     *                 "name": "Moscow"
     *             },
     *             "children": {},
     *             "type": {
     *                 "id": 3,
     *                 "name": "Business",
     *                 "description": "Бизнес пользователь"
     *             },
     *             "longitude": "55.7522",
     *             "latitude": "55.7522",
     *             "language": "Russian",
     *             "short_lang": "ru-RU",
     *             "timezone": "Europe/Moscow"
     *           },
     *           "banned": {
     *             "is_banned": false,
     *             "banned_reason": null,
     *             "banned_at": null
     *           }
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
    public function actionRegistrationBusiness()
    {
        return $this->api->registrationBusiness($this->post);
    }

    /**
     * @OA\Get(
     *   path="/user/get/",
     *   summary="Получить информацию о пользователе",
     *   tags={"Пользователь | User"},
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *       description="ID пользователя (если ID не установлен, то вернется профиль текущего пользователя)",
     *       in="query",
     *       name="id",
     *       @OA\Schema(
     *           type="integer",
     *           format="int64"
     *       )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="success",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         example={
     *           "id": 4,
     *           "email": "neo4@neo.com",
     *           "access": {},
     *           "profile": {
     *             "first_name": "Иван",
     *             "last_name": "Иванов",
     *             "phone_number": null,
     *             "address": null,
     *             "about": null,
     *             "country": null,
     *             "city": {
     *               "id": 1,
     *               "name": "Moscow"
     *             },
     *             "children": {
     *               {
     *                 "id": 5,
     *                 "age": 5,
     *                 "gender": {
     *                   "id": 1,
     *                   "name": "Male"
     *                 }
     *               },
     *               {
     *                 "id": 6,
     *                 "age": 11,
     *                 "gender": {
     *                   "id": 2,
     *                   "name": "Female"
     *                 }
     *               }
     *             },
     *             "type": {
     *                 "id": 2,
     *                 "name": "User",
     *                 "description": "Обычный пользователь"
     *             },
     *             "longitude": "55.7522",
     *             "latitude": "37.6156",
     *             "language": "Russian",
     *             "short_lang": "ru-RU",
     *             "timezone": "Europe/Moscow"
     *           },
     *           "banned": {
     *             "is_banned": false,
     *             "banned_reason": null,
     *             "banned_at": null
     *           },
     *         }
     *       ),
     *     ),
     *   ),
     * )
     * @return array
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionGet(): array
    {
        return $this->api->get($this->user, $this->get);
    }

    /**
     * @OA\Post(
     *   path="/user/recovery",
     *   summary="Восстановление профиля",
     *   tags={"Пользователь | User"},
     *   security={{"bearerAuth":{}}},
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
     *         required={
     *             "email"
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
     *           "success": true
     *         }
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="BadRequestHttpException"
     *   )
     * )
     * @throws BadRequestHttpException
     * @throws \yii\base\Exception
     */
    public function actionRecovery(): array
    {
        return $this->api->recovery($this->post);
    }
}
