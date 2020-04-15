<?php

namespace backend\Entity\Moderator\Service;

use common\components\registry\RgUser;
use common\models\user\User;
use yii\web\NotFoundHttpException;

class ModeratorService
{

    /**
     * @param string $field
     * @param $value
     * @throws NotFoundHttpException
     */
    public function validateExists(string $field, $value): void
    {
        $user = User::find()->where([$field => $value])->exists();

        if (!$user) {
            throw new NotFoundHttpException("Пользователь с {$field}: {$value} не найден");
        }
    }

    /**
     * @param string $field
     * @param $value
     * @return User|null
     * @throws NotFoundHttpException
     */
    public function findOne(string $field, $value): ?User
    {
        $this->validateExists($field, $value);

        return User::findOne([$field => $value]);
    }

    /**
     * @param int $id
     * @return bool
     * @throws NotFoundHttpException
     */
    public function changeStatus(int $id): bool
    {
        $user = $this->findOne('id', $id);
        $user->status = RgUser::STATUS_ACTIVE;

        return true;
    }
}
