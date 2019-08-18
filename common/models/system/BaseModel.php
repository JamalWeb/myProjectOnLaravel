<?php

namespace common\models\system;

use api\modules\v1\models\error\BadRequestHttpException;
use common\components\DateHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class BaseModel
 *
 * @package common\models\system
 */
class BaseModel extends ActiveRecord
{
    /**
     * Автоматическое установление даты и времени при создании или обновлении пользователя
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class'              => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value'              => DateHelper::getTimestamp(),
            ],
        ];
    }

    /**
     * Сохранение модели
     *
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
