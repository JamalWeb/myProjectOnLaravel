<?php

namespace api\modules\v1\classes;

use api\modules\v1\classes\base\Api;
use common\models\event\EventStatus;
use common\models\event\EventType;

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

    /**
     * Получить список статусов
     *
     * @return array
     */
    public function getStatusList(): array
    {
        return EventStatus::find()->all();
    }

    public function create(array $post)
    {
        return [
            '$post' => $post['carrying_date'],
            'files' => $_FILES
        ];
    }
}
