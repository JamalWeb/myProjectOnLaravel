<?php

namespace api\modules\v1\controllers;

use api\modules\v1\classes\CityApi;

/**
 * @property CityApi $api
 */
class CityController extends BaseController
{
    public $modelName = CityApi::class;

    /**
     * @OA\Get(
     *   path="/city/get-list",
     *   summary="Получить список городов",
     *   tags={"Город | City"},
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
     *              "name": "Moscow"
     *           },
     *           {
     *              "id": 2,
     *              "name": "San Francisco"
     *           }
     *         }
     *       ),
     *     ),
     *   ),
     * )
     */
    public function actionGetList(): array
    {
        return $this->api->getList();
    }
}
