<?php

namespace api\modules\v1\classes;

use api\modules\v1\classes\base\Api;
use common\models\event\EventType;

class EventApi extends Api
{
    public function create(array $post)
    {
        return $post;
    }

    /**
     * Получить список типов
     *
     * @return array
     */
    public function getTypeList(): array
    {
        return EventType::find()->all();
    }
}
