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
    public function actionGetGenders(): void
    {
        $this->response = $this->api->getGender();
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
    public function actionRegistrationUser(): void
    {
        $this->response = $this->api->registrationUser($this->post);
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
    public function actionRegistrationBusinessUser(): void
    {
        $this->response = $this->api->registrationBusinessUser();
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
    public function actionLogin(): void
    {
        $this->response = $this->api->login($this->post);
    }

    /**
     * @OA\Delete(
     *     path="/pet/{petId}",
     *     summary="Deletes a pet",
     *     description="",
     *     operationId="deletePet",
     *     tags={"pet"},
     *     @OA\Parameter(
     *         description="Pet id to delete",
     *         in="path",
     *         name="petId",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Header(
     *         header="api_key",
     *         description="Api key header",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pet not found"
     *     ),
     *     security={{"petstore_auth":{"write:pets", "read:pets"}}}
     * )
     */
    public function actionResetAuthToken(): void
    {
        $this->response = $this->api->resetAuthToken($this->post);
    }
}
