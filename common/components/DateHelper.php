<?php

namespace common\components;

use common\components\helpers\SystemFn;

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
    public static final function getTimestamp(string $changeDate = ''): string
    {
        if (empty($changeDate)) {
            $timestamp = SystemFn::gmdate('Y-m-d H:i:s');
        } else {
            $timestamp = SystemFn::gmdate('Y-m-d H:i:s', SystemFn::strtotime($changeDate));
        }

        return $timestamp;
    }
}
