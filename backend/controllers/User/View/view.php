<?php
/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var User $user
 */

use common\models\user\User;
use yii\bootstrap4\Html;
use yii\web\View;
use yii\widgets\DetailView;

?>

<h4>
    <?= $this->title ?> |
    <?= Html::a(
        '<ion-icon name="trash-outline" size="small" style="color:red"></ion-icon>',
        [
            'user/delete',
            'id' => $user->id,
        ],
        [
            'id' => 'deleteItem',
        ]
    ) ?>
</h4>
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
            'username',
            'role.name',
            'profile.first_name',
            'profile.last_name',
            'profile.patronymic',
            'profile.phone_number',
            'profile.address',
            'profile.short_lang',
            'profile.about:ntext',
            'type.name',
            'email',
            'logged_in_ip',
            'logged_in_at',
            'logout_in_at',
            'profile.gender.name',
            'created_ip',
            'is_banned',
            'banned_at',
            'status.name',
            'created_at',
            'updated_at',
        ],
    ]
) ?>
