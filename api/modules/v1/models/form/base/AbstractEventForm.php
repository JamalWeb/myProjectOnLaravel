<?php

namespace api\modules\v1\models\form\base;

use Yii;
use yii\base\Model;

class AbstractEventForm extends Model
{

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'type_id'                => Yii::t('app', 'Type ID'),
            'status_id'              => Yii::t('app', 'Status ID'),
            'name'                   => Yii::t('app', 'Name'),
            'about'                  => Yii::t('app', 'About'),
            'interest_category_id'   => Yii::t('app', 'Interest Category ID'),
            'city_id'                => Yii::t('app', 'City ID'),
            'address'                => Yii::t('app', 'Address'),
            'age_limit'              => Yii::t('app', 'Age Limit'),
            'ticket_price'           => Yii::t('app', 'Ticket Price'),
            'tickets_number'         => Yii::t('app', 'Tickets Number'),
            'additional_information' => Yii::t('app', 'Additional Information'),
            'is_free'                => Yii::t('app', 'Is Free'),
            'wallpaper'              => Yii::t('app', 'Wallpaper'),
            'created_at'             => Yii::t('app', 'Created At'),
            'updated_at'             => Yii::t('app', 'Updated At'),
        ];
    }
}
