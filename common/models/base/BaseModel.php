<?php

namespace common\models\base;

use api\modules\v1\models\error\BadRequestHttpException;
use common\components\ArrayHelper;
use common\components\registry\AttrRegistry;
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
                'createdAtAttribute' => AttrRegistry::CREATED_AT,
                'updatedAtAttribute' => AttrRegistry::UPDATED_AT,
                'value'              => gmdate('Y-m-d H:i:s'),
            ],
        ]);
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
