<?php

namespace common\components;

use api\modules\v1\models\error\BadRequestHttpException;
use Yii;
use yii\web\IdentityInterface;

/**
 * Class User
 *
 * @package common\components
 */
class User extends \yii\web\User
{
    /**
     * @param IdentityInterface $identity
     * @param bool              $cookieBased
     * @param int               $duration
     * @throws BadRequestHttpException
     */
    protected function afterLogin($identity, $cookieBased, $duration)
    {
        parent::afterLogin($identity, $cookieBased, $duration);
        /** @var \common\models\user\User $identity */
        $identity->saveModel([
            'logged_in_ip' => Yii::$app->request->remoteIP,
            'logged_in_at' => DateHelper::getTimestamp()
        ]);
    }

    /**
     * @param IdentityInterface $identity
     * @throws BadRequestHttpException
     */
    protected function afterLogout($identity)
    {
        parent::afterLogout($identity);

        parent::afterLogout($identity);
        /** @var \common\models\user\User $identity */
        $identity->saveModel([
            'logout_in_ip' => Yii::$app->request->remoteIP,
            'logout_in_at' => DateHelper::getTimestamp()
        ]);
    }
}
