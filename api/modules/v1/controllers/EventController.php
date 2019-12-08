<?php

namespace api\modules\v1\controllers;

use api\modules\v1\classes\EventApi;

/**
 * @property EventApi $api
 */
class EventController extends BaseController
{
    protected $modelName = EventApi::class;

    /**
     * @OA\Post(
     *   path="/event/create",
     *   summary="Создать",
     *   tags={"Событие | Event"},
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
     *           property="age_limit",
     *           description="Возрастная категория",
     *           type="integer",
     *           example=18
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
     *           property="is_free",
     *           description="Бесплатное?",
     *           type="integer",
     *           enum={0, 1},
     *           example="0"
     *         ),
     *         @OA\Property(
     *             property="wallpaper",
     *             description="Фоновая картинка",
     *             type="file",
     *             format="file",
     *         ),
     *         @OA\Property(
     *           property="carrying_date",
     *           description="Список дат проведения мероприятий с продолжительностью",
     *           type="object",
     *           example={
     *             {
     *               "date": "2019-12-09 16:00:00",
     *               "duration": 2
     *             },
     *             {
     *               "date": "2019-12-08 16:00:00",
     *               "duration": 3
     *             },
     *           }
     *         ),
     *         required={
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
     *         }
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="BadRequestHttpException"
     *   )
     * )
     */
    public function actionCreate()
    {
        return $this->api->create($this->post);
    }

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
}
