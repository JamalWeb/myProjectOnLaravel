<?php

namespace common\models\relations;

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use common\models\base\BaseModel;
use common\models\InterestCategory;
use common\models\user\User;
use Yii;
use yii\db\ActiveQuery;

/**
 * @property int              $id                   Идентификатор связи пользователя с его интересами
 * @property int              $user_id              Идентификатор пользователя
 * @property int              $interest_category_id Идентификатор интереса
 * @property string           $created_at           Дата создания
 * @property string           $updated_at           Дата обновления
 * @property InterestCategory $interest
 * @property User             $user
 */
class RelationUserInterest extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return RgTable::NAME_RELATION_USER_INTEREST;
    }

    /**
     * @return ActiveQuery
     */
    public function getInterest()
    {
        return $this->hasOne(
            InterestCategory::class,
            [
                RgAttribute::ID => RgAttribute::INTEREST_CATEGORY_ID
            ]
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(
            User::class,
            [
                RgAttribute::ID => RgAttribute::USER_ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            RgAttribute::ID                   => Yii::t('app', 'ID'),
            RgAttribute::USER_ID              => Yii::t('app', 'User ID'),
            RgAttribute::INTEREST_CATEGORY_ID => Yii::t('app', 'Interest Category ID'),
            RgAttribute::CREATED_AT           => Yii::t('app', 'Created At'),
            RgAttribute::UPDATED_AT           => Yii::t('app', 'Updated At'),
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
                    RgAttribute::INTEREST_CATEGORY_ID
                ],
                'required'
            ],
            [
                [
                    RgAttribute::USER_ID,
                    RgAttribute::INTEREST_CATEGORY_ID
                ],
                'default',
                'value' => null
            ],
            [
                [
                    RgAttribute::USER_ID,
                    RgAttribute::INTEREST_CATEGORY_ID
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
            [
                [RgAttribute::INTEREST_CATEGORY_ID],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => InterestCategory::class,
                'targetAttribute' => [
                    RgAttribute::INTEREST_CATEGORY_ID => RgAttribute::ID
                ]
            ],
            [
                [RgAttribute::USER_ID],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::class,
                'targetAttribute' => [
                    RgAttribute::USER_ID => RgAttribute::ID
                ]
            ],
        ];
    }
}
