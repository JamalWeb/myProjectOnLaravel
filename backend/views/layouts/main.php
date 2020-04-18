<?php

/* @var $this View */

/* @var $content string */

use backend\assets\AppAsset;
use common\helpers\UserPermissionsHelper;
use common\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\web\View;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin(
        [
            'brandLabel' => Yii::$app->name,
            'brandUrl'   => Yii::$app->homeUrl,
        ]
    );
    if (Yii::$app->user->isGuest) {
        $menuItems[] =
            [
                'label'   => '<ion-icon name="enter-outline" size="large"></ion-icon>',
                'url'     => ['/site/login'],
                'encode'  => false,
                'options' => ['class' => 'login-btn']
            ];
    } else {
        $menuItems[] =
            [
                'label' => 'Главная',
                'url'   => ['/site/index'],
            ];

        if (UserPermissionsHelper::isAdmin(Yii::$app->user->identity->getId())) {
            $menuItems[] =
                [
                    'label' => 'Пользователи',
                    'url'   => ['/admin/index'],
                ];
        }

        if (UserPermissionsHelper::isCan('moderationOfEvents')) {
            $menuItems[] =
                [
                    'label'   => 'Модерация',
                    'options' => ['class' => 'nav-item dropdown'],
                    'items'   => [
                        ['label' => 'Пользователи', 'url' => '/moderator/user-list'],
                        ['label' => 'События', 'url' => '/moderator/event-list']
                    ]

                ];
        }

        $menuItems[] =
            [
                'label' => 'Кабинет',
                'url'   => ['/cabinet/index'],
            ];

        $menuItems[] =
            [
                'label'   => '<ion-icon name="exit-outline" size="large"></ion-icon>',
                'url'     => ['/site/logout'],
                'encode'  => false,
                'options' => ['class' => 'logout-btn']
            ];
    }
    echo Nav::widget(
        [
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items'   => $menuItems,
        ]
    );
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget(
            [
                'links' => $this->params['breadcrumbs'] ?? [],
            ]
        ) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
