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
     * @return string
     */
    public static final function getTimestamp(): string
    {
        return gmdate('Y-m-d H:i:s');
    }
}
