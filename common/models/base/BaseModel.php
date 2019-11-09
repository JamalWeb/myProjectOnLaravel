<?php

namespace common\models\base;

use api\modules\v1\models\error\BadRequestHttpException;
use common\components\ArrayHelper;
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
        $behaviors = parent::behaviors();
        if (isset($this->created_at) && isset($this->updated_at)) {
            $behaviors = ArrayHelper::merge($behaviors, [
                'timestamp' => [
                    'class'              => TimestampBehavior::class,
                    'createdAtAttribute' => 'created_at',
                    'updatedAtAttribute' => 'updated_at',
                    'value'              => gmdate('Y-m-d H:i:s'),
                ],
            ]);
        }

        return $behaviors;
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
