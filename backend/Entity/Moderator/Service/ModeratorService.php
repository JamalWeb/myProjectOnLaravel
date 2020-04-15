<?php

namespace backend\Entity\Moderator\Service;

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
     * @param int $newStatusId
     * @return bool
     * @throws NotFoundHttpException
     */
    public function changeStatus(int $id, int $newStatusId): bool
    {
        $user = $this->findOne('id', $id);
        $user->status_id = $newStatusId;

        return $user->save();
    }
}
