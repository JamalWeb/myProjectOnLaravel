<?php

namespace common\models;

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
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
        return RgTable::NAME_INTEREST_CATEGORY;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            RgAttribute::ID   => Yii::t('app', 'ID'),
            RgAttribute::NAME => Yii::t('app', 'Name'),
            RgAttribute::IMG  => Yii::t('app', 'Img'),
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
                    RgAttribute::NAME,
                    RgAttribute::IMG
                ],
                'required'
            ],
            [
                [
                    RgAttribute::NAME,
                    RgAttribute::IMG
                ],
                'string',
                'max' => 255
            ],
        ];
    }
}
