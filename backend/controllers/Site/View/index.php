<?php

/**
 * @var View $this
 * @var string $appName
 * @var User $user
 */

use common\models\user\User;
use yii\web\View;

?>
<div class="jumbotron">
    <h1 class="display-4">Привет, <?= $this->context->authorizedUser->email ?> !</h1>
    <p class="lead">Это простой пример блока с компонентом в стиле jumbotron для
        привлечения дополнительного внимания к содержанию или информации.</p>
    <hr class="my-4">
    <p class="lead">
        <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
    </p>
</div>
