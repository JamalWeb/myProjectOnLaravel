<?php

namespace common\models\system;

use api\modules\v1\models\error\BadRequestHttpException;
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

    /**
     * @return bool
     * @throws BadRequestHttpException
     */
    public final function saveModel(): bool
    {
        if (!$this->save()) {
            throw new BadRequestHttpException($this->getFirstErrors());
        }

        return true;
    }
}
