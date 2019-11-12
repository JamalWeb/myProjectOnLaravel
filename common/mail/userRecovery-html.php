<?php

use common\models\user\User;
use common\models\user\UserToken;
use yii\helpers\Html;

/**
 * @var $this      yii\web\View
 * @var $user      User
 * @var $userToken UserToken
 */

$link = Yii::$app->urlManager->createAbsoluteUrl([
    'confirm/user-recovery',
    'token' => $userToken->access_token
]);
?>
<div class="user-recovery">
    <h1>Восстановление учетной записи</h1>
    <p>Привет, <?= Html::encode($user->fullName) ?>, Ваш адрес электронной почты был указан как контактный при
        восстановление учетной записи.</p>
    <p>Перейдите по ссылке ниже, чтобы сменить пароль:</p>

    <p><?= Html::a(Html::encode($link), $link) ?></p>

    <p>Если вы не запрашивали восстановление учетной записи проигнорируйте данное сообщение.</p>
</div>
