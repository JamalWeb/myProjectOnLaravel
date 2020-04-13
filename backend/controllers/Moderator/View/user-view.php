<?php

use common\models\user\User;
use yii\web\View;
use yii\widgets\DetailView;

/**
 * @var User $user
 * @var View $this
 */
$this->params['breadcrumbs'][] = ['label' => 'Список', 'url' => ['user-list']];
$this->params['breadcrumbs'][] = $this->title
?>

<div class="row">
    <div class="col-md-6">
        <h3><?= $this->title ?></h3>
    </div>
</div>

<?= DetailView::widget(
    [
        'model'      => $user,
        'attributes' => [
            [
                'label'     => '№',
                'attribute' => 'id',
            ],
            [
                'attribute' => 'profile.id',
                'label'     => 'Аватар',
                'value'     => $user->profile->avatar,
            ],
            [
                'attribute' => 'status.name',
                'label'     => 'Статус',
                'value'     => $user->status->name
            ],
            'username',
            'role.name',
            'profile.first_name',
            'profile.last_name',
            'profile.patronymic',
            'profile.phone_number',
            'profile.short_lang',
            'profile.about:ntext',
            'type.name',
            'email',
            'profile.gender.name',
            'is_banned',
            'banned_at',
        ],
    ]
) ?>
