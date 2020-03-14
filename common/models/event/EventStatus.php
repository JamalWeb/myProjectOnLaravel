<?php

namespace common\models\event;

use common\components\registry\RgAttribute;
use yii\web\BadRequestHttpException;

class EventStatus
{
    public const MODERATION = 1;
    public const NEW = 2;
    public const COMPLETED = 3;
    public const CANCELED = 4;
    public const NOT_ACTIVE = 5;

    private static $statusList = [
        self::MODERATION => 'На модерации',
        self::NEW        => 'Новое',
        self::COMPLETED  => 'Завершено',
        self::CANCELED   => 'Отменено',
        self::NOT_ACTIVE => 'Не активно'
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
        if (!isset(self::$statusList[$id])) {
            throw new BadRequestHttpException('Event status not found');
        }

        return self::$statusList[$id];
    }

    /**
     * @return array
     */
    public static function getList(): array
    {
        return [
            [
                RgAttribute::ID          => self::MODERATION,
                RgAttribute::NAME        => 'На модерации',
                RgAttribute::DESCRIPTION => 'Проходит модерацию админами'
            ],
            [
                RgAttribute::ID          => self::NEW,
                RgAttribute::NAME        => 'Новое',
                RgAttribute::DESCRIPTION => 'Новое событие'
            ],
            [
                RgAttribute::ID          => self::COMPLETED,
                RgAttribute::NAME        => 'Завершено',
                RgAttribute::DESCRIPTION => 'Событие было завершено'
            ],
            [
                RgAttribute::ID          => self::CANCELED,
                RgAttribute::NAME        => 'Отменено',
                RgAttribute::DESCRIPTION => 'Событие было отменено'
            ],
            [
                RgAttribute::ID          => self::NOT_ACTIVE,
                RgAttribute::NAME        => 'Не активно',
                RgAttribute::DESCRIPTION => 'Событие временно не активно'
            ]
        ];
    }
}
