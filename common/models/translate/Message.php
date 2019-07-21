<?php

namespace common\models\translate;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "message".
 *
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
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'language'], 'required'],
            [['id'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['translation'], 'string'],
            [['language'], 'string', 'max' => 16],
            [['id', 'language'], 'unique', 'targetAttribute' => ['id', 'language']],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => SourceMessage::class, 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('api', 'ID'),
            'language'    => Yii::t('api', 'Language'),
            'translation' => Yii::t('api', 'Translation'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(SourceMessage::class, ['id' => 'id']);
    }
}
