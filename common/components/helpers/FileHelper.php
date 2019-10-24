<?php

namespace common\components\helpers;

use api\modules\v1\models\error\BadRequestHttpException;
use Exception;

/**
 * Class FileHelper
 *
 * @package common\components\helpers
 */
class FileHelper
{
    /**
     * Создание директории
     *
     * @param string $path
     * @param int    $mode
     * @return bool
     * @throws BadRequestHttpException
     */
    public static function createDir(string $path, int $mode): bool
    {
        try {
            if (!file_exists($path)) {
                return mkdir($path, $mode);
            }

            return false;
        } catch (Exception $e) {
            throw new BadRequestHttpException(['dir' => $e->getMessage()]);
        }
    }
}
