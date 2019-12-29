<?php

namespace common\models;

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
use common\models\base\BaseModel;
use Yii;

/**
 * @property int    $id   Идентификатор интереса
 * @property string $name Наименование интереса
 * @property string $img  Наименование картинки
 */
class InterestCategory extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return TableRegistry::NAME_INTEREST_CATEGORY;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            AttrRegistry::ID   => Yii::t('app', 'ID'),
            AttrRegistry::NAME => Yii::t('app', 'Name'),
            AttrRegistry::IMG  => Yii::t('app', 'Img'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    AttrRegistry::NAME,
                    AttrRegistry::IMG
                ],
                'required'
            ],
            [
                [
                    AttrRegistry::NAME,
                    AttrRegistry::IMG
                ],
                'string',
                'max' => 255
            ],
        ];
    }
}
