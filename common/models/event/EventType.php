<?php

namespace common\models\event;

use common\components\registry\RgAttribute;
use yii\web\BadRequestHttpException;

class EventType
{
    const ONE_DAY = 1;
    const MULTIPLE_DAYS = 2;
    const REGULAR = 3;

    private static $typeList = [
        self::ONE_DAY       => 'One-day event',
        self::MULTIPLE_DAYS => 'Multiple-days event',
        self::REGULAR       => 'Regular event',
    ];

    /**
     * Получить наименование типа
     *
     * @param int $id
     * @return string
     * @throws BadRequestHttpException
     */
    public static function getName(int $id): string
    {
        if (!isset(self::$typeList[$id])) {
            throw new BadRequestHttpException('Event type not found');
        }

        return self::$typeList[$id];
    }

    /**
     * Получить список типов
     *
     * @return array
     */
    public static function getList(): array
    {
        return [
            [
                RgAttribute::ID          => self::ONE_DAY,
                RgAttribute::NAME        => 'One-day event',
                RgAttribute::DESCRIPTION => 'Событие на один день'
            ],
            [
                RgAttribute::ID          => self::MULTIPLE_DAYS,
                RgAttribute::NAME        => 'Multiple-days event',
                RgAttribute::DESCRIPTION => 'Событие на несколько дней'
            ],
            [
                RgAttribute::ID          => self::REGULAR,
                RgAttribute::NAME        => 'Regular event',
                RgAttribute::DESCRIPTION => 'Повторяющееся событие'
            ],
        ];
    }
}
