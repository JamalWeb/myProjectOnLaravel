<?php

namespace common\components;

use common\components\helpers\SystemFn;
use DateTimeImmutable;

/**
 * Class DateHelper
 *
 * @package common\components
 */
class DateHelper
{
    /**
     *Текущая дата в формате 2019-07-13 18:27:52
     *
     * @param string $changeDate
     * @return string
     */
    final public static function getTimestamp(string $changeDate = ''): string
    {
        if (empty($changeDate)) {
            $timestamp = SystemFn::gmdate('Y-m-d H:i:s');
        } else {
            $timestamp = SystemFn::gmdate('Y-m-d H:i:s', SystemFn::strtotime($changeDate));
        }

        return $timestamp;
    }

    public static function checkFormatDate(string $date, string $format): bool
    {
        $date = DateTimeImmutable::createFromFormat($format, $date);

        return $date && $date->format($format) === $date;
    }
}
