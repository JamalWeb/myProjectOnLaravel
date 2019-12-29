<?php

namespace common\models\user;

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
use Yii;
use common\models\base\BaseModel;
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
        return TableRegistry::NAME_USER_CHILDREN;
    }

    /**
     * @return ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(
            User::class,
            [
                AttrRegistry::ID => AttrRegistry::USER_ID
            ]
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(
            UserGender::class,
            [
                AttrRegistry::ID => AttrRegistry::GENDER_ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            AttrRegistry::ID         => Yii::t('app', 'ID'),
            AttrRegistry::USER_ID    => Yii::t('app', 'User ID'),
            AttrRegistry::AGE        => Yii::t('app', 'Age'),
            AttrRegistry::GENDER_ID  => Yii::t('app', 'Gender ID'),
            AttrRegistry::CREATED_AT => Yii::t('app', 'Created At'),
            AttrRegistry::UPDATED_AT => Yii::t('app', 'Updated At'),
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
                    AttrRegistry::USER_ID,
                    AttrRegistry::AGE,
                    AttrRegistry::GENDER_ID
                ],
                'required'
            ],
            [
                [
                    AttrRegistry::USER_ID,
                    AttrRegistry::AGE,
                    AttrRegistry::GENDER_ID
                ],
                'default',
                'value' => null
            ],
            [
                [
                    AttrRegistry::USER_ID,
                    AttrRegistry::AGE,
                    AttrRegistry::GENDER_ID
                ],
                'integer'
            ],
            [
                [
                    AttrRegistry::CREATED_AT,
                    AttrRegistry::UPDATED_AT
                ],
                'safe'
            ],
        ];
    }
}
