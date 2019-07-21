<?php

namespace common\components;

use Exception;

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
}
