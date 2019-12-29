<?php

namespace api\modules\v1\models\form\base;

use common\components\registry\RgAttribute;
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
            RgAttribute::TYPE_ID                => Yii::t('app', 'Type ID'),
            RgAttribute::STATUS_ID              => Yii::t('app', 'Status ID'),
            RgAttribute::NAME                   => Yii::t('app', 'Name'),
            RgAttribute::ABOUT                  => Yii::t('app', 'About'),
            RgAttribute::INTEREST_CATEGORY_ID   => Yii::t('app', 'Interest Category ID'),
            RgAttribute::CITY_ID                => Yii::t('app', 'City ID'),
            RgAttribute::ADDRESS                => Yii::t('app', 'Address'),
            RgAttribute::AGE_LIMIT              => Yii::t('app', 'Age Limit'),
            RgAttribute::TICKET_PRICE           => Yii::t('app', 'Ticket Price'),
            RgAttribute::TICKETS_NUMBER         => Yii::t('app', 'Tickets Number'),
            RgAttribute::ADDITIONAL_INFORMATION => Yii::t('app', 'Additional Information'),
            RgAttribute::IS_FREE                => Yii::t('app', 'Is Free'),
            RgAttribute::WALLPAPER              => Yii::t('app', 'Wallpaper'),
            RgAttribute::CREATED_AT             => Yii::t('app', 'Created At'),
            RgAttribute::UPDATED_AT             => Yii::t('app', 'Updated At'),
        ];
    }
}
