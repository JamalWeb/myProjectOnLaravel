<?php

namespace common\components;

use api\modules\v1\models\error\BadRequestHttpException;
use common\components\helpers\SystemFn;
use Exception;
use Generator;
use Yii;

/**
 * Class ArrayHelper
 *
 * @package common\components
 */
class ArrayHelper extends \yii\helpers\ArrayHelper
{
    /**
     * Json в Array
     *
     * @param string $json
     * @return array
     * @throws Exception
     */
    final public static function jsonToArray(?string $json): array
    {
        try {
            $array = [];
            if (!empty($json)) {
                /** @var array $array */
                $array = SystemFn::jsonDecode($json, true, 512, JSON_THROW_ON_ERROR);
            }

            return (array)$array;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Проверка ключей или значения на пустоту
     *
     * @param       $array
     * @param array $keys
     * @param bool  $checkForEmpty
     * @throws BadRequestHttpException
     */
    public static function validateParams(array &$array, array $keys, bool $checkForEmpty = true): void
    {
        self::cleaning($array, $keys);

        foreach (self::generator($keys) as $key) {
            if (!SystemFn::keyExists($key, $array)) {
                throw new BadRequestHttpException(
                    [
                        $key => Yii::t(
                            'yii',
                            'Missing required parameters: {params}',
                            [
                                'params' => "«{$key}»"
                            ]
                        )
                    ]
                );
            }

            if ($checkForEmpty && empty($array[$key])) {
                throw new BadRequestHttpException(
                    [
                        $key => Yii::t(
                            'yii',
                            '{attribute} cannot be blank.',
                            [
                                'attribute' => $key
                            ]
                        )
                    ]
                );
            }
        }
    }

    /**
     * Удаляет ключей которых нет в массиве $keys
     *
     * @param $array
     * @param $keys
     */
    public static function cleaning(array &$array, array $keys): void
    {
        $cleanParams = [];
        foreach (self::generator($keys) as $key) {
            if (!SystemFn::keyExists($key, $array)) {
                continue;
            }
            $cleanParams[$key] = $array[$key];
        }
        $array = $cleanParams;
    }

    /**
     * Генератор, для ускорения работы перебора массивов/объектов
     *
     * @param $array
     * @return Generator
     */
    public static function generator(array $array): Generator
    {
        if (SystemFn::isIterable($array)) {
            foreach ($array as $item) {
                yield $item;
            }
        }
    }
}
