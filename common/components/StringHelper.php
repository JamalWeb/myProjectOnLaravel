<?php

namespace common\components;

class StringHelper extends \yii\helpers\StringHelper
{
    /**
     * Форматируем пол
     *
     * @param string $gender
     * @return string
     */
    final public static function getFirstLetter(string $gender): string
    {
        /**
         * Получаем первую букву строки
         */
        $gender = mb_substr($gender, 0, 1, 'UTF-8');

        /**
         * Преобразовываем в верхний регистр
         */
        $gender = mb_strtoupper($gender);

        return $gender;
    }
}
