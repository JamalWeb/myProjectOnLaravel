<?php

namespace common\models\translate;

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
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
        return RgTable::NAME_MESSAGE;
    }

    /**
     * @return ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(
            SourceMessage::class,
            [
                RgAttribute::ID => RgAttribute::ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            RgAttribute::ID          => Yii::t('api', 'ID'),
            RgAttribute::LANGUAGE    => Yii::t('api', 'Language'),
            RgAttribute::TRANSLATION => Yii::t('api', 'Translation'),
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
                    RgAttribute::ID,
                    RgAttribute::LANGUAGE
                ],
                'required'
            ],
            [
                [RgAttribute::ID],
                'default',
                'value' => null
            ],
            [
                [RgAttribute::ID],
                'integer'
            ],
            [
                [RgAttribute::TRANSLATION],
                'string'
            ],
            [
                [RgAttribute::LANGUAGE],
                'string',
                'max' => 16
            ],
            [
                [
                    RgAttribute::ID,
                    RgAttribute::LANGUAGE
                ],
                'unique',
                'targetAttribute' => [
                    RgAttribute::ID,
                    RgAttribute::LANGUAGE
                ]
            ],
            [
                [RgAttribute::ID],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => SourceMessage::class,
                'targetAttribute' => [
                    RgAttribute::ID => RgAttribute::ID
                ]
            ],
        ];
    }
}
