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
    'confirm/email',
    'token' => $userToken->access_token
]);
?>
<div class="verify-email">
    <h1>Подтверждение адреса электронной почты</h1>
    <p>Привет, <?= Html::encode($user->fullName) ?>, Ваш адрес электронной почты был указан как контактный при регистрации.</p>
    <p>Благодарим за регистрацию в сервисе <b>MAPPA</b>. Теперь у Вас есть доступ к сервису.</p>
    <p>Перейдите по ссылке ниже, чтобы подтвердить свою электронную почту:</p>

    <p><?= Html::a(Html::encode($link), $link) ?></p>
</div>
