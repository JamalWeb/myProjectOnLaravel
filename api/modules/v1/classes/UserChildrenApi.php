<?php

namespace api\modules\v1\classes;

use api\modules\v1\classes\base\Api;
use common\components\registry\RgAttribute;
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
                $child = new UserChildren();
                $childParam[RgAttribute::USER_ID] = $user->id;
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
