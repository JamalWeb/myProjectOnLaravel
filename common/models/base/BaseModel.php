<?php

namespace common\models\base;

use api\modules\v1\models\error\BadRequestHttpException;
use common\components\ArrayHelper;
use common\components\registry\RgAttribute;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class BaseModel
 *
 * @property array $publicInfo Общая информация
 * @package common\models\system
 */
abstract class BaseModel extends ActiveRecord
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'timestamp' => [
                    'class'              => TimestampBehavior::class,
                    'createdAtAttribute' => RgAttribute::CREATED_AT,
                    'updatedAtAttribute' => RgAttribute::UPDATED_AT,
                    'value'              => gmdate('Y-m-d H:i:s'),
                ],
            ]
        );
    }

    public function getPublicInfo(): array
    {
        return [];
    }

    /**
     * Сохранение модели
     *
     * @param array $attributes
     * @return bool
     * @throws BadRequestHttpException
     */
    final public function saveModel(array $attributes = []): bool
    {
        if (!empty($attributes)) {
            $this->setAttributes($attributes);
        }

        if (!$this->save()) {
            throw new BadRequestHttpException($this->getFirstErrors());
        }

        $this->refresh();

        return true;
    }
}
