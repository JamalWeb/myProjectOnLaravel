<?php

namespace common\components;

use yii\base\Component;

/**
 * Class DateHelper - Хелпер для работы датой
 *
 * @package common\components
 */
class DateHelper extends Component
{
    public static final function getTimestamp(): string
    {
        /**
         * Текущая дата в формате
         * 2019-07-13 18:27:52
         * для базы данных
         *
         * @var string $timestamp
         */
        $timestamp = gmdate('Y-m-d H:i:s');

        return $timestamp;
    }
}
