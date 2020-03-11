<?php

namespace common\components\helpers;

use common\components\ArrayHelper;
use Yii;
use yii\base\Exception;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

/**
 * Class FileHelper
 *
 * @package common\components\helpers
 */
class FileHelper extends \yii\helpers\FileHelper
{
    /**
     * Сохранение файла
     *
     * @param string       $path
     * @param UploadedFile $file
     * @return string
     * @throws Exception
     * @throws BadRequestHttpException
     */
    public static function saveFile(string $path, UploadedFile $file): string
    {
        if ($file === null) {
            throw new BadRequestHttpException('$file is null');
        }

        self::createDirectory($path, 755);
        $fileName = Yii::$app->security->generateRandomString(10);
        $fileExtension = $file->extension;

        $fileName = "{$fileName}.$fileExtension";

        $avatarPath = "{$path}/{$fileName}";
        $file->saveAs($avatarPath);

        return $fileName;
    }

    /**
     * @param string $path
     * @param array  $files
     * @return array
     * @throws Exception
     * @throws BadRequestHttpException
     */
    public static function saveFiles(string $path, array $files): array
    {
        $fileNames = [];
        foreach (ArrayHelper::generator($files) as $file) {
            if (!($file instanceof UploadedFile)) {
                throw new BadRequestHttpException('$file not instance UploadFile');
            }
            $fileNames[] = self::saveFile($path, $file);
        }

        return $fileNames;
    }
}
