<?php

namespace api\modules\v1\models\form;

use api\modules\v1\models\error\UnauthorizedHttpException;
use common\components\registry\RgAttribute;
use common\components\registry\RgUser;
use common\models\user\User;
use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 *
 * @package api\modules\v1\models\form
 */
class LoginForm extends Model
{
    /** @var int */
    public const COUNT_ATTEMPT = 10;

    /** @var int */
    public const TIME_UNAUTHORIZED_DURATION = 600;

    /** @var string $keyAttempts */
    private $keyAttempts;

    /** @var User $user */
    private $user;

    /** @var string $email */
    public $email;

    /** @var string $password */
    public $password;

    /**
     * @return bool
     * @throws UnauthorizedHttpException
     */
    public function beforeValidate(): bool
    {
        $parent = parent::beforeValidate();

        if ($this->email !== null) {
            $this->createKeyAttempts();

            $countAttempt = Yii::$app->cache->get($this->keyAttempts);
            if ($countAttempt >= self::COUNT_ATTEMPT) {
                throw new UnauthorizedHttpException(
                    [
                        'attempt_error' => 'Вы превысили лимит попыток авторизации'
                    ]
                );
            }
        }

        return $parent;
    }

    /**
     * @throws UnauthorizedHttpException
     */
    public function afterValidate(): void
    {
        parent::afterValidate();

        $this->getUser();

        if ($this->user === null) {
            $this->handleFailure();
            throw new UnauthorizedHttpException(
                [
                    RgAttribute::EMAIL => Yii::t('app', 'Email not found')
                ]
            );
        }
    }

    /**
     * Получить пользователя
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        if ($this->user === null) {
            $this->user = User::find()
                ->where(
                    [
                        RgAttribute::EMAIL => $this->email
                    ]
                )
                ->one();
        }

        return $this->user;
    }

    /**
     * Авторизация
     *
     * @return User
     * @throws UnauthorizedHttpException
     */
    final public function authenticate(): User
    {
        if (!$this->validate()) {
            throw new UnauthorizedHttpException($this->getFirstErrors());
        }

        if (!$this->user->validatePassword($this->password)) {
            $this->handleFailure();
            throw new UnauthorizedHttpException(
                [
                    RgAttribute::PASSWORD => Yii::t('app', 'Incorrect password')
                ]
            );
        }

        if ($this->user->is_banned) {
            throw new UnauthorizedHttpException(
                [
                    RgAttribute::EMAIL => Yii::t(
                        'app',
                        'User is banned - {banned_reason}',
                        [
                            RgAttribute::BANNED_REASON => $this->user->banned_reason,
                        ]
                    )
                ]
            );
        }

        $i = $this->user->status_id;
        if ($i === RgUser::STATUS_INACTIVE) {
            $error = [
                RgAttribute::EMAIL => 'Ваш аккаунт отключен'
            ];
        }

        if (isset($error)) {
            throw new UnauthorizedHttpException($error);
        }

//        Язык системы
//        Yii::$app->language = 'ru';
//        if (isset($user['language'])) {
//            Yii::$app->language = mb_strtolower($params['language']);
//        }

        $user = Yii::$app->user;
        $user->switchIdentity($this->user);
        $user->login($this->user);
        $user->setIdentity($this->user);

        Yii::$app->cache->delete($this->keyAttempts);

        return $this->user;
    }

    private function createKeyAttempts(): void
    {
        $this->keyAttempts = 'auth_' . md5($this->email);
    }

    private function handleFailure(): void
    {
        $attempt = Yii::$app->cache->get($this->keyAttempts) ? 1 : 0;
        Yii::$app->cache->set($this->keyAttempts, ($attempt + 1), self::TIME_UNAUTHORIZED_DURATION);
    }

    /**
     * {@inheritDoc}
     */
    public function attributeLabels(): array
    {
        return [
            RgAttribute::EMAIL    => 'Email',
            RgAttribute::PASSWORD => 'Password'
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            [
                [
                    RgAttribute::EMAIL,
                    RgAttribute::PASSWORD
                ],
                'required'
            ],
            [
                [
                    RgAttribute::EMAIL,
                    RgAttribute::PASSWORD
                ],
                'string'
            ],
            [
                [RgAttribute::EMAIL],
                'email'
            ],
        ];
    }
}
