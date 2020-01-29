<?php

namespace api\modules\v1\controllers;

use api\modules\v1\classes\EventApi;
use Exception;
use yii\web\BadRequestHttpException;

/**
 * @property EventApi $api
 */
class EventController extends BaseController
{
    protected $modelName = EventApi::class;

    /**
     * @OA\Get(
     *   path="/event/get-type-list",
     *   summary="Получить список типов",
     *   tags={"Событие | Event"},
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
     *              "name": "One-day event",
     *              "desc": "Событие на один день"
     *           },
     *           {
     *              "id": 2,
     *              "name": "Multiple-days event",
     *              "desc": "Событие на несколько дней"
     *           },
     *           {
     *              "id": 3,
     *              "name": "Regular event",
     *              "desc": "Повторяющееся событие"
     *           }
     *         }
     *       ),
     *     ),
     *   ),
     * )
     */
    public function actionGetTypeList(): array
    {
        return $this->api->getTypeList();
    }

    /**
     * @OA\Get(
     *   path="/event/get-status-list",
     *   summary="Получить список статусов",
     *   tags={"Событие | Event"},
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
     *              "name": "Новое",
     *              "desc": "Новое событие"
     *           },
     *           {
     *              "id": 2,
     *              "name": "Завершено",
     *              "desc": "Событие было завершено"
     *           },
     *           {
     *              "id": 3,
     *              "name": "Отменено",
     *              "desc": "Событие было отменено"
     *           },
     *           {
     *              "id": 4,
     *              "name": "Не активно",
     *              "desc": "Событие временно не активно"
     *           }
     *         }
     *       ),
     *     ),
     *   ),
     * )
     */
    public function actionGetStatusList(): array
    {
        return $this->api->getStatusList();
    }

    /**
     * @OA\Post(
     *   path="/event/create",
     *   summary="Создать",
     *   tags={"Событие | Event"},
     *   security={{"bearerAuth":{}}},
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="type_id",
     *           description="ID типа события",
     *           type="integer",
     *           example=1
     *         ),
     *         @OA\Property(
     *           property="name",
     *           description="Название",
     *           type="string",
     *           example="Праздник"
     *         ),
     *         @OA\Property(
     *           property="about",
     *           description="Описание",
     *           type="string",
     *           example="Описание"
     *         ),
     *         @OA\Property(
     *           property="interest_category_id",
     *           description="ID категория интереса",
     *           type="integer",
     *           example=1
     *         ),
     *         @OA\Property(
     *           property="city_id",
     *           description="ID города",
     *           type="integer",
     *           example=1
     *         ),
     *         @OA\Property(
     *           property="address",
     *           description="Адрес проведения",
     *           type="string",
     *           example="ул.Тергенева д.23 кв.15"
     *         ),
     *         @OA\Property(
     *           property="min_age_child",
     *           description="Возрастная категория",
     *           type="integer",
     *           example=18
     *         ),
     *         @OA\Property(
     *           property="max_age_child",
     *           description="Бесплатное?",
     *           type="integer",
     *           example=21
     *         ),
     *         @OA\Property(
     *           property="ticket_price",
     *           description="Цена за 1 билет",
     *           type="number",
     *           example=1536.51
     *         ),
     *         @OA\Property(
     *           property="tickets_number",
     *           description="Количество билетов",
     *           type="integer",
     *           example=2000
     *         ),
     *         @OA\Property(
     *           property="additional_information",
     *           description="Дополнительная информация",
     *           type="string",
     *           example="Дополнительная информация"
     *         ),
     *         @OA\Property(
     *             property="wallpaper",
     *             description="Фоновая картинка",
     *             type="file",
     *             format="file",
     *         ),
     *         @OA\Property(
     *             property="photo_gallery[]",
     *             description="Фотогалерея",
     *             type="file",
     *             format="file"
     *         ),
     *         @OA\Property(
     *           property="carrying_date",
     *           description="Список дат проведения мероприятий с продолжительностью",
     *           type="object",
     *           example={
     *             {
     *               "date": "2019-12-09 16:00:00",
     *               "duration": "2:30"
     *             },
     *             {
     *               "date": "2019-12-09 16:00:00",
     *               "duration": "3:00"
     *             },
     *           }
     *         ),
     *         required={
     *             "type_id",
     *             "name",
     *             "about",
     *             "interest_category_id",
     *             "city_id",
     *             "address",
     *             "min_age_child",
     *             "wallpaper",
     *             "carrying_date"
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
     *           "id": 1,
     *           "name": "7 f f .",
     *           "about": "ОписаниеОписание",
     *           "address": "Адрес проведения",
     *           "ticket_price": "0.00",
     *           "tickets_number": 2000,
     *           "additional_information": "Дополнительная информация",
     *           "wallpaper": "http://project.loc/upload/events/1/1/wallpaper/__A9h_yHLs.jpg",
     *           "user": {
     *             "id": 1,
     *             "email": "arsen-web@yandex.ru",
     *             "access": {},
     *             "profile": {
     *               "first_name": "Admin",
     *               "last_name": null,
     *               "phone_number": null,
     *               "address": null,
     *               "about": null,
     *               "country": null,
     *               "city": {
     *                 "id": 1,
     *                 "name": "Moscow"
     *               },
     *               "children": {},
     *               "type": {
     *                   "id": 2,
     *                   "name": "User",
     *                   "description": "Обычный пользователь"
     *               },
     *               "longitude": null,
     *               "latitude": null,
     *                 "language": "Russian",
     *                 "short_lang": "ru-RU",
     *                 "timezone": "Europe/Moscow"
     *             },
     *             "banned": {
     *                 "is_banned": false,
     *                 "banned_reason": null,
     *                 "banned_at": null
     *             }
     *           },
     *           "age_limit": {
     *             "min": 0,
     *             "max": 3
     *           },
     *           "type": {
     *             "id": 1,
     *             "name": "One-day event"
     *           },
     *           "status": {
     *             "id": 1,
     *             "name": "На модерации"
     *           },
     *           "interest_category": {
     *             "id": 1,
     *             "name": "Entertainment"
     *           },
     *           "city": {
     *             "id": 1,
     *             "name": "Moscow"
     *           },
     *           "carrying_date": {
     *             {
     *               "id": 1,
     *               "date": "2019-12-09 16:00:00",
     *               "duration": "02:30:00"
     *             },
     *             {
     *               "id": 2,
     *               "date": "2019-12-08 16:00:00",
     *               "duration": "01:00:00"
     *             }
     *           },
     *           "photo_gallery": {
     *             {
     *               "id": 1,
     *               "url": "http://project.loc/upload/events/1/1/photo_gallery/FZFTtO6dLX.jpg"
     *             },
     *             {
     *               "id": 2,
     *               "url": "http://project.loc/upload/events/1/1/photo_gallery/zLShhWC3oq.jpg"
     *             }
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
    public function actionCreate()
    {
        return $this->api->create($this->user, $this->post);
    }

    /**
     * @OA\Get(
     *   path="/event/get/",
     *   summary="Получить информацию о событии",
     *   tags={"Событие | Event"},
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *       description="ID события",
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
     *           "id": 1,
     *           "name": "7 f f .",
     *           "about": "ОписаниеОписание",
     *           "address": "Адрес проведения",
     *           "ticket_price": "0.00",
     *           "tickets_number": 2000,
     *           "additional_information": "Дополнительная информация",
     *           "wallpaper": "http://project.loc/upload/events/1/1/wallpaper/__A9h_yHLs.jpg",
     *           "user": {
     *             "id": 1,
     *             "email": "arsen-web@yandex.ru",
     *             "access": {},
     *             "profile": {
     *               "first_name": "Admin",
     *               "last_name": null,
     *               "phone_number": null,
     *               "address": null,
     *               "about": null,
     *               "country": null,
     *               "city": {
     *                 "id": 1,
     *                 "name": "Moscow"
     *               },
     *               "children": {},
     *               "type": {
     *                   "id": 2,
     *                   "name": "User",
     *                   "description": "Обычный пользователь"
     *               },
     *               "longitude": null,
     *               "latitude": null,
     *                 "language": "Russian",
     *                 "short_lang": "ru-RU",
     *                 "timezone": "Europe/Moscow"
     *             },
     *             "banned": {
     *                 "is_banned": false,
     *                 "banned_reason": null,
     *                 "banned_at": null
     *             }
     *           },
     *           "age_limit": {
     *             "min": 0,
     *             "max": 3
     *           },
     *           "type": {
     *             "id": 1,
     *             "name": "One-day event"
     *           },
     *           "status": {
     *             "id": 1,
     *             "name": "На модерации"
     *           },
     *           "interest_category": {
     *             "id": 1,
     *             "name": "Entertainment"
     *           },
     *           "city": {
     *             "id": 1,
     *             "name": "Moscow"
     *           },
     *           "carrying_date": {
     *             {
     *               "id": 1,
     *               "date": "2019-12-09 16:00:00",
     *               "duration": "02:30:00"
     *             },
     *             {
     *               "id": 2,
     *               "date": "2019-12-08 16:00:00",
     *               "duration": "01:00:00"
     *             }
     *           },
     *           "photo_gallery": {
     *             {
     *               "id": 1,
     *               "url": "http://project.loc/upload/events/1/1/photo_gallery/FZFTtO6dLX.jpg"
     *             },
     *             {
     *               "id": 2,
     *               "url": "http://project.loc/upload/events/1/1/photo_gallery/zLShhWC3oq.jpg"
     *             }
     *           }
     *         }
     *       ),
     *     ),
     *   ),
     * )
     * @return array
     * @throws \api\modules\v1\models\error\BadRequestHttpException
     * @throws BadRequestHttpException
     */
    public function actionGet(): array
    {
        return $this->api->get($this->get);
    }

    /**
     * @OA\Get(
     *   path="/event/get-list-by-user/",
     *   summary="Получить список событий пользователя",
     *   tags={"Событие | Event"},
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *       description="ID пользователя (если ID не установлен, то вернется список событий текущего пользователя)",
     *       in="query",
     *       name="user_id",
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
     *           "items":{
     *             {
     *               "id": 1,
     *               "name": "7 f f .",
     *               "about": "ОписаниеОписание",
     *               "address": "Адрес проведения",
     *               "ticket_price": "0.00",
     *               "tickets_number": 2000,
     *               "additional_information": "Дополнительная информация",
     *               "wallpaper": "http://project.loc/upload/events/1/1/wallpaper/__A9h_yHLs.jpg",
     *               "user": {
     *                 "id": 1,
     *                 "email": "arsen-web@yandex.ru",
     *                 "access": {},
     *                 "profile": {
     *                   "first_name": "Admin",
     *                   "last_name": null,
     *                   "phone_number": null,
     *                   "address": null,
     *                   "about": null,
     *                   "country": null,
     *                   "city": {
     *                     "id": 1,
     *                     "name": "Moscow"
     *                   },
     *                   "children": {},
     *                   "type": {
     *                       "id": 2,
     *                       "name": "User",
     *                       "description": "Обычный пользователь"
     *                   },
     *                   "longitude": null,
     *                   "latitude": null,
     *                     "language": "Russian",
     *                     "short_lang": "ru-RU",
     *                     "timezone": "Europe/Moscow"
     *                 },
     *                 "banned": {
     *                     "is_banned": false,
     *                     "banned_reason": null,
     *                     "banned_at": null
     *                 }
     *               },
     *               "age_limit": {
     *                 "min": 0,
     *                 "max": 3
     *               },
     *               "type": {
     *                 "id": 1,
     *                 "name": "One-day event"
     *               },
     *               "status": {
     *                 "id": 1,
     *                 "name": "На модерации"
     *               },
     *               "interest_category": {
     *                 "id": 1,
     *                 "name": "Entertainment"
     *               },
     *               "city": {
     *                 "id": 1,
     *                 "name": "Moscow"
     *               },
     *               "carrying_date": {
     *                 {
     *                   "id": 1,
     *                   "date": "2019-12-09 16:00:00",
     *                   "duration": "02:30:00"
     *                 },
     *                 {
     *                   "id": 2,
     *                   "date": "2019-12-08 16:00:00",
     *                   "duration": "01:00:00"
     *                 }
     *               },
     *               "photo_gallery": {
     *                 {
     *                   "id": 1,
     *                   "url": "http://project.loc/upload/events/1/1/photo_gallery/FZFTtO6dLX.jpg"
     *                 },
     *                 {
     *                   "id": 2,
     *                   "url": "http://project.loc/upload/events/1/1/photo_gallery/zLShhWC3oq.jpg"
     *                 }
     *               }
     *             },
     *             {
     *               "id": 1,
     *               "name": "7 f f .",
     *               "about": "ОписаниеОписание",
     *               "address": "Адрес проведения",
     *               "ticket_price": "0.00",
     *               "tickets_number": 2000,
     *               "additional_information": "Дополнительная информация",
     *               "wallpaper": "http://project.loc/upload/events/1/1/wallpaper/__A9h_yHLs.jpg",
     *               "user": {
     *                 "id": 1,
     *                 "email": "arsen-web@yandex.ru",
     *                 "access": {},
     *                 "profile": {
     *                   "first_name": "Admin",
     *                   "last_name": null,
     *                   "phone_number": null,
     *                   "address": null,
     *                   "about": null,
     *                   "country": null,
     *                   "city": {
     *                     "id": 1,
     *                     "name": "Moscow"
     *                   },
     *                   "children": {},
     *                   "type": {
     *                       "id": 2,
     *                       "name": "User",
     *                       "description": "Обычный пользователь"
     *                   },
     *                   "longitude": null,
     *                   "latitude": null,
     *                     "language": "Russian",
     *                     "short_lang": "ru-RU",
     *                     "timezone": "Europe/Moscow"
     *                 },
     *                 "banned": {
     *                     "is_banned": false,
     *                     "banned_reason": null,
     *                     "banned_at": null
     *                 }
     *               },
     *               "age_limit": {
     *                 "min": 0,
     *                 "max": 3
     *               },
     *               "type": {
     *                 "id": 1,
     *                 "name": "One-day event"
     *               },
     *               "status": {
     *                 "id": 1,
     *                 "name": "На модерации"
     *               },
     *               "interest_category": {
     *                 "id": 1,
     *                 "name": "Entertainment"
     *               },
     *               "city": {
     *                 "id": 1,
     *                 "name": "Moscow"
     *               },
     *               "carrying_date": {
     *                 {
     *                   "id": 1,
     *                   "date": "2019-12-09 16:00:00",
     *                   "duration": "02:30:00"
     *                 },
     *                 {
     *                   "id": 2,
     *                   "date": "2019-12-08 16:00:00",
     *                   "duration": "01:00:00"
     *                 }
     *               },
     *               "photo_gallery": {
     *                 {
     *                   "id": 1,
     *                   "url": "http://project.loc/upload/events/1/1/photo_gallery/FZFTtO6dLX.jpg"
     *                 },
     *                 {
     *                   "id": 2,
     *                   "url": "http://project.loc/upload/events/1/1/photo_gallery/zLShhWC3oq.jpg"
     *                 }
     *               }
     *             }
     *           },
     *           "pagination": {
     *             "page": 1,
     *             "page_size": 2,
     *             "total_page": 2,
     *             "total_count": 4
     *           }
     *         }
     *       ),
     *     ),
     *   ),
     * )
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionGetListByUser(): array
    {
        return $this->api->getListByUser($this->user, $this->get);
    }
}
