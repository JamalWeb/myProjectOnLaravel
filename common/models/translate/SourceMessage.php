<?php

namespace common\models\translate;

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
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
        return TableRegistry::NAME_SOURCE_MESSAGE;
    }

    /**
     * @return ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(
            Message::class,
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
            AttrRegistry::ID       => Yii::t('api', 'ID'),
            AttrRegistry::CATEGORY => Yii::t('api', 'Category'),
            AttrRegistry::MESSAGE  => Yii::t('api', 'Message'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [AttrRegistry::MESSAGE],
                'string'
            ],
            [
                [AttrRegistry::CATEGORY],
                'string',
                'max' => 255
            ],
        ];
    }
}
