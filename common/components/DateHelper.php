<?php

namespace common\components;

use yii\base\BaseObject;

/**
 * Class DateHelper
 *
 * @package common\components
 */
class DateHelper extends BaseObject
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
            $timestamp = gmdate('Y-m-d H:i:s');
        } else {
            $timestamp = gmdate('Y-m-d H:i:s', strtotime($changeDate));
        }

        return $timestamp;
    }
}
