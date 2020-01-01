<?php

namespace common\models\user;

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use Yii;
use common\models\base\BaseModel;

/**
 * @property int    $id                Идентификатор типа
 * @property string $name              Наименование
 * @property string $description       Описание
 * @property string $created_at        Дата создания
 * @property string $updated_at        Дата обновления
 */
class UserType extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return RgTable::NAME_USER_TYPE;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            RgAttribute::ID          => Yii::t('app', 'ID'),
            RgAttribute::NAME        => Yii::t('app', 'Name'),
            RgAttribute::DESCRIPTION => Yii::t('app', 'Description'),
            RgAttribute::CREATED_AT  => Yii::t('app', 'Created At'),
            RgAttribute::UPDATED_AT  => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [RgAttribute::NAME],
                'required'
            ],
            [
                [
                    RgAttribute::CREATED_AT,
                    RgAttribute::UPDATED_AT
                ],
                'safe'
            ],
            [
                [
                    RgAttribute::NAME,
                    RgAttribute::DESCRIPTION
                ],
                'string',
                'max' => 255
            ],
        ];
    }
}
