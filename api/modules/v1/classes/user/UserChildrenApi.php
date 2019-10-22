<?php

namespace api\modules\v1\classes\user;

use api\modules\v1\classes\Api;
use common\components\ArrayHelper;
use common\models\user\User;
use common\models\user\UserChildren;
use Exception;
use Yii;

class UserChildrenApi extends Api
{
    /**
     * Добавление детей пользователю
     *
     * @param User  $user
     * @param array $childrenParams
     * @return array
     * @throws Exception
     */
    public function add(User $user, array $childrenParams): array
    {
        $children = [];
        if (empty($childrenParams)) {
            return $children;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($childrenParams as $childParam) {
                $childParam = ArrayHelper::merge($childParam, [
                    'user_id' => $user->id
                ]);

                $child = new UserChildren();
                $child->saveModel($childParam);

                $children[] = $child;
            }

            $transaction->commit();

            return $children;
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
