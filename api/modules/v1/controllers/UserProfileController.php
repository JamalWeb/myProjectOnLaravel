<?php
/** @noinspection PhpUnused */

namespace api\modules\v1\controllers;

use api\modules\v1\classes\UserProfileApi;
use api\modules\v1\models\error\BadRequestHttpException;

/**
 * @property UserProfileApi $api
 */
class UserProfileController extends BaseController
{
    public $modelName = UserProfileApi::class;

    /**
     * @OA\Get(
     *   path="/user-profile/get",
     *   summary="Получить информацию о пользователе",
     *   tags={"Профиль пользователя | UserProfile"},
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *       description="Идентификатор пользователя",
     *       in="query",
     *       name="user_id",
     *       required=true,
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
     * @throws BadRequestHttpException
     */
    public function actionGet(): array
    {
        return $this->api->get($this->get);
    }

    /**
     * @OA\Post(
     *   path="/user-profile/update-default-user",
     *   summary="Редактирование профиля обычного пользователя",
     *   tags={"Профиль пользователя | UserProfile"},
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
     *                 "country": {
     *                     "id": 1,
     *                     "name": "Russia"
     *                 },
     *                 "city": {
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
     * @throws BadRequestHttpException
     */
    public function actionUpdateDefaultUser(): array
    {
        return $this->api->updateDefaultUser($this->user, $this->post);
    }
}
