<?php

namespace common\components;

use Exception;
use Generator;

class ArrayHelper extends \yii\helpers\ArrayHelper
{
    /**
     * @param string $json
     * @return mixed
     * @throws Exception
     */
    public static final function jsonToArray(string $json)
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
     * Генератор, для ускорения работы перебора массивов/объектов
     *
     * @param $array
     * @return Generator
     */
    public static function generator($array)
    {
        if (is_iterable($array)) {
            foreach ($array as $item) {
                yield $item;
            }
        }
    }
}
