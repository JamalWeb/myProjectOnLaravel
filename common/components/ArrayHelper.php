<?php

namespace common\components;

use api\modules\v1\models\error\BadRequestHttpException;
use Exception;
use Generator;
use Yii;

class ArrayHelper extends \yii\helpers\ArrayHelper
{
    /**
     * Json в Array
     *
     * @param string $json
     * @return array
     * @throws Exception
     */
    public static final function jsonToArray(string $json): array
    {
        try {
            $array = [];
            if ($json !== '') {
                /** @var array $array */
                $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
            }

            return $array;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Проверка ключей или значения на пустоту
     *
     * @param       $array
     * @param array $keys
     * @param bool  $checkForAvailabilityOnly
     * @throws BadRequestHttpException
     */
    public static final function validateRequestParams(array $array, array $keys, bool $checkForAvailabilityOnly = true): void
    {
        foreach ($keys as $key) {
            if (!key_exists($key, $array)) {
                throw new BadRequestHttpException([
                    $key => Yii::t('yii', 'Missing required parameters: {params}', [
                        'params' => "«" . ucfirst($key) . "»"
                    ])
                ]);
            }

            if ($checkForAvailabilityOnly && empty($array[$key])) {
                throw new BadRequestHttpException([
                    $key => Yii::t('yii', '{attribute} cannot be blank.', [
                        'attribute' => $key
                    ])
                ]);
            }
        }
    }

    /**
     * Генератор, для ускорения работы перебора массивов/объектов
     *
     * @param $array
     * @return Generator
     */
    public static function generator($array): Generator
    {
        if (is_iterable($array)) {
            foreach ($array as $item) {
                yield $item;
            }
        }
    }
}
