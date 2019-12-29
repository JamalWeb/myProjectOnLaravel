<?php

namespace api\modules\v1\models\form\base;

use common\components\registry\AttrRegistry;
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
            AttrRegistry::TYPE_ID                => Yii::t('app', 'Type ID'),
            AttrRegistry::STATUS_ID              => Yii::t('app', 'Status ID'),
            AttrRegistry::NAME                   => Yii::t('app', 'Name'),
            AttrRegistry::ABOUT                  => Yii::t('app', 'About'),
            AttrRegistry::INTEREST_CATEGORY_ID   => Yii::t('app', 'Interest Category ID'),
            AttrRegistry::CITY_ID                => Yii::t('app', 'City ID'),
            AttrRegistry::ADDRESS                => Yii::t('app', 'Address'),
            AttrRegistry::AGE_LIMIT              => Yii::t('app', 'Age Limit'),
            AttrRegistry::TICKET_PRICE           => Yii::t('app', 'Ticket Price'),
            AttrRegistry::TICKETS_NUMBER         => Yii::t('app', 'Tickets Number'),
            AttrRegistry::ADDITIONAL_INFORMATION => Yii::t('app', 'Additional Information'),
            AttrRegistry::IS_FREE                => Yii::t('app', 'Is Free'),
            AttrRegistry::WALLPAPER              => Yii::t('app', 'Wallpaper'),
            AttrRegistry::CREATED_AT             => Yii::t('app', 'Created At'),
            AttrRegistry::UPDATED_AT             => Yii::t('app', 'Updated At'),
        ];
    }
}
