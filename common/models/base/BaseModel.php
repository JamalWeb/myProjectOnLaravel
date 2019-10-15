<?php

namespace common\models\base;

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
                'value'              => gmdate('Y-m-d H:i:s'),
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
     * @param array $attributes
     * @return bool
     * @throws BadRequestHttpException
     */
    public final function saveModel(array $attributes = []): bool
    {
        if (!empty($attributes)) {
            $this->setAttributes($attributes);
        }

        if (!$this->save()) {
            throw new BadRequestHttpException($this->getFirstErrors());
        }

        return true;
    }
}
