<?php

namespace common\models\translate;

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int           $id
 * @property string        $language
 * @property string        $translation
 * @property SourceMessage $id0
 */
class Message extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return TableRegistry::NAME_MESSAGE;
    }

    /**
     * @return ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(
            SourceMessage::class,
            [
                AttrRegistry::ID => AttrRegistry::ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            AttrRegistry::ID          => Yii::t('api', 'ID'),
            AttrRegistry::LANGUAGE    => Yii::t('api', 'Language'),
            AttrRegistry::TRANSLATION => Yii::t('api', 'Translation'),
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
                    AttrRegistry::ID,
                    AttrRegistry::LANGUAGE
                ],
                'required'
            ],
            [
                [AttrRegistry::ID],
                'default',
                'value' => null
            ],
            [
                [AttrRegistry::ID],
                'integer'
            ],
            [
                [AttrRegistry::TRANSLATION],
                'string'
            ],
            [
                [AttrRegistry::LANGUAGE],
                'string',
                'max' => 16
            ],
            [
                [
                    AttrRegistry::ID,
                    AttrRegistry::LANGUAGE
                ],
                'unique',
                'targetAttribute' => [
                    AttrRegistry::ID,
                    AttrRegistry::LANGUAGE
                ]
            ],
            [
                [AttrRegistry::ID],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => SourceMessage::class,
                'targetAttribute' => [
                    AttrRegistry::ID => AttrRegistry::ID
                ]
            ],
        ];
    }
}
