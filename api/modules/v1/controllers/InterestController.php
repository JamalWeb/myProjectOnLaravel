<?php

namespace api\modules\v1\controllers;

use api\modules\v1\classes\InterestApi;
use yii\base\InvalidConfigException;

/**
 * @property InterestApi $api
 */
class InterestController extends BaseController
{
    public $modelName = InterestApi::class;

    /**
     * @OA\Get(
     *   path="/interest/get",
     *   summary="Получить список интересов",
     *   tags={"Интересы | Interest"},
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *     response=200,
     *     description="success",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         example={
     *           {
     *             "id": 1,
     *             "name": "Entertainment",
     *             "img": "http://mappa.one/upload/system/interest/entertainment.png"
     *           },
     *           {
     *             "id": 2,
     *             "name": "Art",
     *             "img": "http://mappa.one/upload/system/interest/art.png"
     *           },
     *           {
     *             "id": 3,
     *             "name": "Sport",
     *             "img": "http://mappa.one/upload/system/interest/sport.png"
     *           },
     *           {
     *             "id": 4,
     *             "name": "Music",
     *             "img": "http://mappa.one/upload/system/interest/music.png"
     *           },
     *           {
     *             "id": 5,
     *             "name": "Education",
     *             "img": "http://mappa.one/upload/system/interest/education.png"
     *           }
     *         }
     *       ),
     *     ),
     *   ),
     * )
     * @throws InvalidConfigException
     */
    public function actionGet()
    {
        return $this->api->get();
    }
}
