<?php

namespace common\models\system;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{
    /**
     * Автоматическое установление даты и времени при
     * создании или обновлении пользователя
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class'              => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value'              => gmdate('Y-m-d H:i:s'),
            ],
        ];
    }
}
