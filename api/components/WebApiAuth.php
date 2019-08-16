<?php

namespace api\components;

use common\models\LoginForm;
use Exception;
use Yii;
use yii\base\InvalidConfigException;
use yii\filters\auth\AuthMethod;
use yii\web\IdentityInterface;
use yii\web\Request;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;
use yii\web\User;

/**
 * Class WebApiAuth
 *
 * @package api_web\components
 */
class WebApiAuth extends AuthMethod
{
    private $keyCache;

    /**
     * @param User     $user
     * @param Request  $request
     * @param Response $response
     * @return IdentityInterface|null
     * @throws UnauthorizedHttpException
     * @throws InvalidConfigException
     */
    public function authenticate($user, $request, $response)
    {
        $identity = null;
        $params = $request->getBodyParams();
        $email = $params['email'] ?? null;
        $password = $params['password'] ?? null;

        if (!is_null($email) && !is_null($password)) {
            $hashEmail = md5($email);
            $this->keyCache = "auth_{$hashEmail}";
            $attempt = Yii::$app->cache->get($this->keyCache);
            if ($attempt >= 10) {
                throw new UnauthorizedHttpException('You enter the password too often, rest for 10 minutes.');
            }
        }

        if (!empty($params)) {
            if (isset($params['user']['token']) || !is_null($email)) {
                //Авторизация по токену
                if (isset($params['user']['token'])) {
                    $token = $this->getToken($params['user']['token']);
                    //Для методов неподтвержденного поставщика используем JWT
                    try {
                        $jwtToken = Yii::$app->jwt->getParser()->parse($token);
                        $identity = User::getByJWTToken(Yii::$app->jwt, $jwtToken);
                    } catch (Exception $e) {
                        $this->handleFailure($e->getMessage());
                    }
                }
                //Авторизация по логину и паролю в параметрах запроса
                if (!is_null($email) && !is_null($password)) {
                    $model = new LoginForm([
                        'email'    => $email,
                        'password' => $password
                    ]);
                    $identity = ($model->validate()) ? $model->getUser() : null;
                }
                //Если авторизовали пользователя
                if ($identity !== null) {
                    $user->switchIdentity($identity);
                    $user->login($identity);
                    if (isset($params['user']['location'])) {
                        if (isset($params['user']['location']['city'])) {
                            Yii::$app->session->set('city', trim($params['user']['location']['city']));
                        }
                        if (isset($params['user']['location']['region'])) {
                            Yii::$app->session->set('region', trim($params['user']['location']['region']));
                        }
                        if (isset($params['user']['location']['country'])) {
                            Yii::$app->session->set('country', trim($params['user']['location']['country']));
                        }
                    }
                    Yii::$app->cache->delete($this->keyCache);

                    return $identity;
                } else {
                    $this->handleFailure($response);
                }
            }
        }

        return null;
    }

    /**
     * @param $default
     * @return string
     */
    private function getToken($default)
    {
        if (isset($_COOKIE['my_token'])) {
            return $_COOKIE['my_token'];
        }

        return $default;
    }

    /**
     * @param $response
     * @throws UnauthorizedHttpException
     */
    public function handleFailure($response)
    {
        $attempt = Yii::$app->cache->get($this->keyCache) ?? 0;
        Yii::$app->cache->set($this->keyCache, ($attempt + 1), 600);
        throw new UnauthorizedHttpException('auth_failed', 401);
    }
}
