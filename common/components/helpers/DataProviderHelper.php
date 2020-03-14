<?php

namespace common\components\helpers;

use common\components\ArrayHelper;
use common\components\registry\RgAttribute;
use common\models\base\BaseModel;
use yii\data\ActiveDataProvider;
use yii\db\Query;

class DataProviderHelper
{
    /**
     * ActiveDataProvider
     *
     * @param Query $query
     * @param array $params
     * @return array
     */
    public static function active(Query $query, array $params): array
    {
        $page = $params[RgAttribute::PAGE] ?? 1;
        $pageSize = $params[RgAttribute::PAGE_SIZE] ?? 12;

        $provider = new ActiveDataProvider(
            [
                RgAttribute::QUERY => $query,
                RgAttribute::PAGINATION => [
                    RgAttribute::PAGE => ($page - 1),
                    'pageSize' => $pageSize,
                ],
            ]
        );

        return [
            RgAttribute::ITEMS => ArrayHelper::getColumn(
                $provider->models,
                static function (BaseModel $model): ?array {
                    return $model->getPublicInfo();
                },
                false
            ),
            RgAttribute::PAGINATION => [
                RgAttribute::PAGE => ($provider->pagination->page + 1),
                RgAttribute::PAGE_SIZE => $provider->pagination->pageSize,
                RgAttribute::TOTAL_PAGE => ceil($provider->totalCount / $provider->pagination->pageSize),
                RgAttribute::TOTAL_COUNT => $provider->totalCount,
            ],
        ];
    }
}
