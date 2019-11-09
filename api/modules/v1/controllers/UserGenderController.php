<?php

namespace api\modules\v1\controllers;

use api\modules\v1\classes\UserGenderApi;

/**
 * @property UserGenderApi $api
 */
class UserGenderController extends BaseController
{
    public $modelName = UserGenderApi::class;

    /**
     * @OA\Get(
     *   path="/user-gender/get",
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
    public function actionGet(): array
    {
        return $this->api->get();
    }
}
