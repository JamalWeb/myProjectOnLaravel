<?php

use backend\Entity\Services\User\Dto\UserCreateDto;
use yii\helpers\Html;

/**
 * @var $this      yii\web\View
 * @var $dto UserCreateDto
 */

$link = Yii::$app->urlManager->createAbsoluteUrl(
    [
        'confirm/email',
        'token' => $dto->accessToken,
    ]
);
?>
<div class="verify-email">
    <h1>Подтверждение адреса электронной почты</h1>
    <p>Привет, <?= Html::encode($dto->firstName) ?>,
        Ваш адрес электронной почты был указан как контактный при регистрации.</p>
    <p>Благодарим за регистрацию в сервисе <b>MAPPA</b>. Теперь у Вас есть доступ к сервису.</p>
    <p>Перейдите по ссылке ниже, чтобы подтвердить свою электронную почту:</p>
    <p><?= Html::a('Подтвердить email', $link) ?></p>
    <ul>
        <li>Ваша почта: <?= $dto->email ?></li>
        <li>Ваш пароль: <?= $dto->passwordUser ?></li>
    </ul>

</div>
