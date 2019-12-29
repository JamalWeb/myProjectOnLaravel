<?php

namespace common\models\user;

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
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
        return RgTable::NAME_USER_ROLE;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            RgAttribute::ID          => Yii::t('app', 'ID'),
            RgAttribute::NAME        => Yii::t('app', 'Name'),
            RgAttribute::DESCRIPTION => Yii::t('app', 'Desc'),
            RgAttribute::CREATED_AT  => Yii::t('app', 'Created At'),
            RgAttribute::UPDATED_AT  => Yii::t('app', 'Updated At'),
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
                    RgAttribute::NAME,
                    RgAttribute::DESCRIPTION
                ],
                'required'
            ],
            [
                [
                    RgAttribute::CREATED_AT,
                    RgAttribute::UPDATED_AT
                ],
                'safe'
            ],
            [
                [
                    RgAttribute::NAME,
                    RgAttribute::DESCRIPTION
                ],
                'string',
                'max' => 255
            ],
        ];
    }
}
