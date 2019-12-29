<?php

namespace common\models\user;

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
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
    const TYPE_SYSTEM = 1;
    const TYPE_DEFAULT_USER = 2;
    const TYPE_BUSINESS_USER = 3;

    public static $validTypeSearch = [
        self::TYPE_DEFAULT_USER,
        self::TYPE_BUSINESS_USER,
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return TableRegistry::NAME_USER_TYPE;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            AttrRegistry::ID          => Yii::t('app', 'ID'),
            AttrRegistry::NAME        => Yii::t('app', 'Name'),
            AttrRegistry::DESCRIPTION => Yii::t('app', 'Description'),
            AttrRegistry::CREATED_AT  => Yii::t('app', 'Created At'),
            AttrRegistry::UPDATED_AT  => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [AttrRegistry::NAME],
                'required'
            ],
            [
                [
                    AttrRegistry::CREATED_AT,
                    AttrRegistry::UPDATED_AT
                ],
                'safe'
            ],
            [
                [
                    AttrRegistry::NAME,
                    AttrRegistry::DESCRIPTION
                ],
                'string',
                'max' => 255
            ],
        ];
    }
}
