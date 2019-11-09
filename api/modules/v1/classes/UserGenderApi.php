<?php

namespace api\modules\v1\classes;

use api\modules\v1\classes\base\Api;
use common\models\user\UserGender;

class UserGenderApi extends Api
{
    /**
     * Список гендерных принадлежностей
     *
     * @return array
     */
    public final function get(): array
    {
        return UserGender::find()->all();
    }
}
