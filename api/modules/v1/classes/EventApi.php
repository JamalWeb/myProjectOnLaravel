<?php

namespace api\modules\v1\classes;

use api\modules\v1\classes\base\Api;
use common\models\event\EventType;
use yii\web\UploadedFile;

class EventApi extends Api
{
    /**
     * Получить список типов
     *
     * @return array
     */
    public function getTypeList(): array
    {
        return EventType::find()->all();
    }

    public function create(array $post)
    {
        return [
            '$_FILES' => $_FILES,
            '$_POST'  => $_POST
        ];
    }
}
