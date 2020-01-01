<?php

namespace common\models\user;

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use common\models\base\BaseModel;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "user_status".
 *
 * @property int    $id          Идентификатор статуса пользователя
 * @property string $name        Наименование статуса пользователя
 * @property string $description Описание статуса пользователя
 * @property string $created_at  Дата создания
 * @property string $updated_at  Дата обновления
 * @property User[] $users
 */
class UserStatus extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return RgTable::NAME_USER_STATUS;
    }

    /**
     * @return ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(
            User::class,
            [
                RgAttribute::STATUS_ID => RgAttribute::ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            RgAttribute::ID          => Yii::t('app', 'ID'),
            RgAttribute::NAME        => Yii::t('app', 'Name'),
            RgAttribute::DESCRIPTION => Yii::t('app', 'Description'),
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
