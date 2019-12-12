<?php

namespace api\modules\v1\classes;

use api\modules\v1\classes\base\Api;
use common\models\City;

class CityApi extends Api
{
    public function getList()
    {
        return City::find()->all();
    }
}
