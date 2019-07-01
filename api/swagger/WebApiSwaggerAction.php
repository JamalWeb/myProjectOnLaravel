<?php

namespace api\swagger;

use Yii;
use light\swagger\SwaggerApiAction;
use yii\base\ExitException;
use yii\base\InvalidConfigException;

class WebApiSwaggerAction extends SwaggerApiAction
{
    /**
     * @throws ExitException
     * @throws InvalidConfigException
     */
    protected function clearCache()
    {
        $clearCache = Yii::$app->getRequest()->get('clear-cache', false);
        if ($clearCache !== false) {
            $this->getCache()->delete($this->cacheKey);
            Yii::$app->response->content = json_encode(['result' => 'Succeed clear swagger api cache.']);
            Yii::$app->end();
        }
    }

    protected function getSwagger()
    {
        try {
            $result = \Swagger\scan($this->scanDir, $this->scanOptions);

            return $result;
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
