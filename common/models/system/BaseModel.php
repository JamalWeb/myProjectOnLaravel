<?php

namespace common\models\system;

use api\modules\v1\models\error\BadRequestHttpException;
use common\components\ArrayHelper;
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
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'timestamp' => [
                'class'              => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value'              => DateHelper::getTimestamp(),
            ],
        ]);
    }

    /**
     * Запись атрибутов
     *
     * @param array $values
     * @param bool  $safeOnly
     * @return BaseModel
     */
    public function setAttributes($values, $safeOnly = true): self
    {
        if (is_array($values)) {
            $attributes = array_flip($safeOnly ? $this->safeAttributes() : $this->attributes());
            foreach ($values as $name => $value) {
                if (isset($attributes[$name])) {
                    $this->$name = $value;
                } elseif ($safeOnly) {
                    $this->onUnsafeAttribute($name, $value);
                }
            }
        }

        return $this;
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
