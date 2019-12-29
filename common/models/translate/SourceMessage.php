<?php

namespace common\models\translate;

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int       $id
 * @property string    $category
 * @property string    $message
 * @property Message[] $messages
 */
class SourceMessage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return RgTable::NAME_SOURCE_MESSAGE;
    }

    /**
     * @return ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(
            Message::class,
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
            RgAttribute::ID       => Yii::t('api', 'ID'),
            RgAttribute::CATEGORY => Yii::t('api', 'Category'),
            RgAttribute::MESSAGE  => Yii::t('api', 'Message'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [RgAttribute::MESSAGE],
                'string'
            ],
            [
                [RgAttribute::CATEGORY],
                'string',
                'max' => 255
            ],
        ];
    }
}
