<?php

/**
 * @var ActiveDataProvider $dataProvider
 * @var UserSearch $searchModel
 * @var View $this
 */


use backend\models\User\UserSearch;
use common\models\user\User;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\View;

?>
    <h3><?= $this->title ?></h3>

<?php
echo GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'showFooter'   => true,
        'columns'      => [
            'id',
            'username',
            'email',
            [
                'attribute' => 'type_id',
                'label'     => 'Тип пользователя',
                'filter'    => Select2::widget(
                    [
                        'name'          => 'UserSearch[type_id]',
                        'data'          => UserSearch::getTypes(),
                        'value'         => $searchModel->type_id,
                        'options'       => [
                            'class'       => 'form-control',
                            'placeholder' => 'Выберите значение',
                        ],
                        'pluginOptions' => [
                            'allowClear'    => true,
                            'selectOnClose' => true,
                        ],
                    ]
                ),
                'value'     => static function (User $model) {
                    return $model->type->name;
                },
            ],
            [
                'attribute' => 'status_id',
                'label'     => 'Статус',
                'filter'    => Select2::widget(
                    [
                        'name'          => 'UserSearch[status_id]',
                        'data'          => UserSearch::getStatuses(),
                        'value'         => $searchModel->status_id,
                        'options'       => [
                            'class'       => 'form-control',
                            'placeholder' => 'Выберите значение',
                        ],
                        'pluginOptions' => [
                            'allowClear'    => true,
                            'selectOnClose' => true,
                        ],
                    ]
                ),
                'value' => static function (User $model): string {
                    return $model->status->name;
                },
            ],
            [
                'attribute' => 'profile.gender_id',
                'label'     => 'Пол',
                'filter'    => Select2::widget(
                    [
                        'name'          => 'UserSearch[gender_id]',
                        'data'          => UserSearch::getGenders(),
                        'value'         => $searchModel->gender_id,
                        'options'       => [
                            'class'       => 'form-control',
                            'placeholder' => 'Выберите значение',
                        ],
                        'pluginOptions' => [
                            'allowClear'    => true,
                            'selectOnClose' => true,
                        ],
                    ]
                ),
                'value'     => static function (User $model) {
                    return $model->profile->gender->name;
                },
            ],
            [
                'class'    => ActionColumn::class,
                'template' => '{user-view} {change-status}',
                'buttons'  => [
                    'user-view' => static function ($url) {
                        return Html::a(
                            '<ion-icon name="eye-outline" size="small"></ion-icon>',
                            $url,
                            [
                                'title' => 'Детальная информация'
                            ]
                        );
                    }
                ],
            ],
        ],
    ]
);
