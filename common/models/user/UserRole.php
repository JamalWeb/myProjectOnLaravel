<?php

namespace common\models\user;

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
use common\models\base\BaseModel;
use Yii;

/**
 * @property int    $id                Идентификатор роли
 * @property string $name              Наименование роли
 * @property string $description       Описание роли
 * @property string $created_at        Дата создания
 * @property string $updated_at        Дата обновления
 */
class UserRole extends BaseModel
{
    const ROLE_ADMIN = 1;
    const ROLE_DEFAULT_USER = 2;
    const ROLE_BUSINESS_USER = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return TableRegistry::NAME_USER_ROLE;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            AttrRegistry::ID          => Yii::t('app', 'ID'),
            AttrRegistry::NAME        => Yii::t('app', 'Name'),
            AttrRegistry::DESCRIPTION => Yii::t('app', 'Desc'),
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
                [
                    AttrRegistry::NAME,
                    AttrRegistry::DESCRIPTION
                ],
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
