<?php

namespace api\modules\v1;

use common\components\ArrayHelper;
use Yii;
use yii\base\Module;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;

/**
 * Class ApiModule
 *
 * @package api\modules\v1
 */
class ApiModule extends Module
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'authenticator' => [
                    'class'       => CompositeAuth::class,
                    'except'      => Yii::$app->params['exceptApiMethods'],
                    'authMethods' => [
                        HttpBearerAuth::class
                    ]
                ]
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
    }
}
