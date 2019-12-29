<?php

namespace common\models\relations;

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
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
        return TableRegistry::NAME_RELATION_USER_INTEREST;
    }

    /**
     * @return ActiveQuery
     */
    public function getInterest()
    {
        return $this->hasOne(
            InterestCategory::class,
            [
                AttrRegistry::ID => AttrRegistry::INTEREST_CATEGORY_ID
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
                AttrRegistry::ID => AttrRegistry::USER_ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            AttrRegistry::ID                   => Yii::t('app', 'ID'),
            AttrRegistry::USER_ID              => Yii::t('app', 'User ID'),
            AttrRegistry::INTEREST_CATEGORY_ID => Yii::t('app', 'Interest Category ID'),
            AttrRegistry::CREATED_AT           => Yii::t('app', 'Created At'),
            AttrRegistry::UPDATED_AT           => Yii::t('app', 'Updated At'),
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
                    AttrRegistry::INTEREST_CATEGORY_ID
                ],
                'required'
            ],
            [
                [
                    AttrRegistry::USER_ID,
                    AttrRegistry::INTEREST_CATEGORY_ID
                ],
                'default',
                'value' => null
            ],
            [
                [
                    AttrRegistry::USER_ID,
                    AttrRegistry::INTEREST_CATEGORY_ID
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
            [
                [AttrRegistry::INTEREST_CATEGORY_ID],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => InterestCategory::class,
                'targetAttribute' => [
                    AttrRegistry::INTEREST_CATEGORY_ID => AttrRegistry::ID
                ]
            ],
            [
                [AttrRegistry::USER_ID],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::class,
                'targetAttribute' => [
                    AttrRegistry::USER_ID => AttrRegistry::ID
                ]
            ],
        ];
    }
}
