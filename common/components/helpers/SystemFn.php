<?php

namespace common\components\helpers;

use common\components\ArrayHelper;

class SystemFn
{
    /**
     * Проверка наличие ключа в массиве
     *
     * @param string $key
     * @param array  $search
     * @return bool верно при успехе или false при неудаче
     * @return bool
     */
    public static function key_exists(string $key, array $search): bool
    {
        return key_exists($key, $search);
    }

    /**
     * Проверка массив или объект, реализующий Traversable
     *
     * @param $value
     * @return bool верно при успехе или false при неудаче
     */
    public static function is_iterable($value): bool
    {
        return is_iterable($value);
    }

    /**
     * Декодирует строку JSON
     *
     * @param      $json
     * @param bool $assoc
     * @param int  $depth
     * @param int  $options
     * @return mixed
     */
    public static function json_decode($json, $assoc = false, $depth = 512, $options = 0)
    {
        return json_decode($json, $assoc, $depth, $options);
    }

    /**
     * Форматирует дату/время по Гринвичу
     * Возвращает строку с форматированной датой.
     * Если для параметра timestamp указано нечисловое значение,
     * то будет возращена пустая строка и вызвана ошибка уровня E_WARNING.
     *
     * @param string   $format
     * @param int|null $timestamp
     * @return string
     */
    public static function gmdate(string $format, ?int $timestamp = null): string
    {
        return gmdate($format, $timestamp);
    }

    /**
     * Преобразует текстовое представление даты на английском языке в метку времени Unix
     * Возвращает временную метку в случае успеха, иначе возвращается 0
     *
     * @param string $time
     * @return int
     */
    public static function strtotime(string $time): int
    {
        $strtotime = strtotime($time, self::time());

        if ($strtotime === false) {
            $strtotime = 0;
        }

        return $strtotime;
    }

    /**
     * Возвращает текущую метку системного времени Unix
     * Возвращает количество секунд,
     * прошедших с начала эпохи Unix (1 января 1970 00:00:00 GMT) до текущего времени.
     *
     * @return int
     */
    public static function time()
    {
        return time();
    }
}
