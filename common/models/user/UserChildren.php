<?php

namespace common\models\user;

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use common\models\base\BaseModel;
use Yii;
use yii\db\ActiveQuery;

/**
 * @property int        $id         Идентификатор ребенка пользователя
 * @property int        $user_id    Идентификатор пользователя
 * @property int        $age        Возраст
 * @property int        $gender_id  Идентификатор пола
 * @property string     $created_at Дата создания
 * @property string     $updated_at Дата обновления
 * @property User       $parent     Родитель
 * @property UserGender $gender     Пол
 */
class UserChildren extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return RgTable::NAME_USER_CHILDREN;
    }

    /**
     * @return ActiveQuery
     */
    public function getParent(): ActiveQuery
    {
        return $this->hasOne(
            User::class,
            [
                RgAttribute::ID => RgAttribute::USER_ID
            ]
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getGender(): ActiveQuery
    {
        return $this->hasOne(
            UserGender::class,
            [
                RgAttribute::ID => RgAttribute::GENDER_ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            RgAttribute::ID         => Yii::t('app', 'ID'),
            RgAttribute::USER_ID    => Yii::t('app', 'User ID'),
            RgAttribute::AGE        => Yii::t('app', 'Age'),
            RgAttribute::GENDER_ID  => Yii::t('app', 'Gender ID'),
            RgAttribute::CREATED_AT => Yii::t('app', 'Created At'),
            RgAttribute::UPDATED_AT => Yii::t('app', 'Updated At'),
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
                    RgAttribute::USER_ID,
                    RgAttribute::AGE,
                    RgAttribute::GENDER_ID
                ],
                'required'
            ],
            [
                [
                    RgAttribute::USER_ID,
                    RgAttribute::AGE,
                    RgAttribute::GENDER_ID
                ],
                'default',
                'value' => null
            ],
            [
                [
                    RgAttribute::USER_ID,
                    RgAttribute::AGE,
                    RgAttribute::GENDER_ID
                ],
                'integer'
            ],
            [
                [
                    RgAttribute::CREATED_AT,
                    RgAttribute::UPDATED_AT
                ],
                'safe'
            ],
        ];
    }
}
