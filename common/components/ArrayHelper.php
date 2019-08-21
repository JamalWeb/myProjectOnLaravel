<?php

namespace common\components;

use api\modules\v1\models\error\BadRequestHttpException;
use Exception;
use Generator;

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
            /** @var array $array */
            $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

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
    public static final function validate(array $array, array $keys, bool $checkForAvailabilityOnly = false): void
    {
        foreach ($keys as $key) {
            if (!key_exists($key, $array)) {
                throw new BadRequestHttpException([$key => 'param_no_isset']);
            }

            if (!$checkForAvailabilityOnly && empty($array[$key])) {
                throw new BadRequestHttpException([$key => 'empty_param']);
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
