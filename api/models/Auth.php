<?php

namespace api\models;

use api\modules\v1\models\error\BadRequestHttpException;
use api\modules\v1\models\error\UnauthorizedHttpException;
use api\modules\v1\models\form\LoginForm;
use Yii;
use yii\filters\auth\AuthMethod;
use yii\web\IdentityInterface;
use yii\web\Request;
use yii\web\Response;
use yii\web\User;

class Auth extends AuthMethod
{
    private $keyAuthCache;

    /**
     * @param User     $user
     * @param Request  $request
     * @param Response $response
     * @return void|IdentityInterface
     * @throws BadRequestHttpException
     * @throws UnauthorizedHttpException
     */
    public function authenticate($user, $request, $response)
    {
        $identity = null;
        $params = $request->post();
        $loginForm = new LoginForm($params);

        if (!$loginForm->validate()) {
            throw new BadRequestHttpException($loginForm->getFirstErrors());
        }

        $this->writeAttemptKey($loginForm);

        $attempt = Yii::$app->cache->get($this->keyAuthCache);
        if ($attempt >= 10) {
            throw new UnauthorizedHttpException(['Вы превысили лимит попыток авторизации']);
        }

        $identity = $loginForm->getUser();

        if (is_null($identity)) {
            throw new UnauthorizedHttpException(['email' => Yii::t('user', 'Email not found')]);
        }

        $user->switchIdentity($identity);
        $user->login($identity);

        Yii::$app->cache->delete($this->keyAuthCache);
        Yii::$app->user->setIdentity($identity);
    }

    private function writeAttemptKey(LoginForm $loginForm): void
    {
        $this->keyAuthCache = 'auth_' . md5($loginForm->email);
    }

    /**
     * @param $response
     */
    public function handleFailure($response)
    {
        $attempt = Yii::$app->cache->get($this->keyAuthCache) ?? 0;
        Yii::$app->cache->set($this->keyAuthCache, ($attempt + 1), 600);
    }
}
