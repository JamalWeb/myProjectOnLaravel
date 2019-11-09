<?php

namespace api\modules\v1\classes;

use api\modules\v1\classes\base\Api;
use common\components\ArrayHelper;
use common\models\Interest;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\UrlManager;

class InterestApi extends Api
{
    /**
     * Список интересов
     *
     * @return Interest[]
     * @throws InvalidConfigException
     */
    public function get(): array
    {
        /** @var Interest[] $interests */
        $interests = Interest::find()->all();

        /** @var UrlManager $urlManagerFront */
        $urlManagerFront = Yii::$app->get('urlManagerFront');

        /** @var string $interestPath */
        $interestPath = Yii::getAlias('@interestPath');

        foreach (ArrayHelper::generator($interests) as $interest) {
            $interest['img'] = "{$urlManagerFront->baseUrl}/$interestPath/{$interest['img']}";
        }

        return $interests;
    }
}
