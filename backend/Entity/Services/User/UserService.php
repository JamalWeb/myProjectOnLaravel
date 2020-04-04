<?php


namespace backend\Entity\Services\User;


use common\models\user\User;
use Throwable;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

class UserService
{
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
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function deleteUser(int $id): bool
    {
        $user = $this->findOne('id', $id);

        return $user->delete() > 0;
    }


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
}
