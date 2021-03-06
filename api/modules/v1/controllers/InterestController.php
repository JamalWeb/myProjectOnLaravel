<?php

namespace api\modules\v1\controllers;

use api\modules\v1\classes\InterestApi;
use api\modules\v1\models\error\BadRequestHttpException;
use yii\base\InvalidConfigException;

/**
 * @property InterestApi $api
 */
class InterestController extends BaseController
{
    public $modelName = InterestApi::class;

    /**
     * @OA\Get(
     *   path="/interest/get-list",
     *   summary="Получить список интересов",
     *   tags={"Интересы | Interest"},
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
    public function actionGetList(): array
    {
        return $this->api->getList();
    }

    /**
     * @OA\Get(
     *   path="/interest/get-interest-user",
     *   summary="Получить список интересов пользователя",
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
     *             "img": "http://mappa.one/upload/system/interest/entertainment.png",
     *             "selected": true
     *           },
     *           {
     *             "id": 2,
     *             "name": "Art",
     *             "img": "http://mappa.one/upload/system/interest/art.png",
     *             "selected": true
     *           },
     *           {
     *             "id": 3,
     *             "name": "Sport",
     *             "img": "http://mappa.one/upload/system/interest/sport.png",
     *             "selected": false
     *           },
     *           {
     *             "id": 4,
     *             "name": "Music",
     *             "img": "http://mappa.one/upload/system/interest/music.png",
     *             "selected": true
     *           },
     *           {
     *             "id": 5,
     *             "name": "Education",
     *             "selected": false
     *           }
     *         }
     *       ),
     *     ),
     *   ),
     * )
     * @throws InvalidConfigException
     */
    public function actionGetInterestUser(): array
    {
        return $this->api->getInterestUser($this->user);
    }

    /**
     * @OA\Post(
     *   path="/interest/set-interest-user",
     *   summary="Записать интересы пользователю",
     *   tags={"Интересы | Interest"},
     *   security={{"bearerAuth":{}}},
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="interest_ids",
     *           description="Идентификаторы интересов",
     *           type="object",
     *           example={
     *             1,
     *             2
     *           }
     *         ),
     *         required={
     *             "interest_ids",
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
     *           {
     *             "id": 1,
     *             "name": "Entertainment",
     *             "img": "http://mappa.one/upload/system/interest/entertainment.png",
     *             "selected": true
     *           },
     *           {
     *             "id": 2,
     *             "name": "Art",
     *             "img": "http://mappa.one/upload/system/interest/art.png",
     *             "selected": true
     *           },
     *           {
     *             "id": 3,
     *             "name": "Sport",
     *             "img": "http://mappa.one/upload/system/interest/sport.png",
     *             "selected": false
     *           },
     *           {
     *             "id": 4,
     *             "name": "Music",
     *             "img": "http://mappa.one/upload/system/interest/music.png",
     *             "selected": true
     *           },
     *           {
     *             "id": 5,
     *             "name": "Education",
     *             "selected": false
     *           }
     *         }
     *       ),
     *     ),
     *   ),
     * )
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionSetInterestUser(): array
    {
        return $this->api->setInterestUser($this->user, $this->post);
    }
}
