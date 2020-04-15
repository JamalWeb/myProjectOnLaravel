<?php

use backend\models\User\UserSearch;
use common\models\user\User;
use kartik\editable\Editable;
use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var ActiveDataProvider $dataProvider
 * @var UserSearch $searchModel
 * @var View $this
 */


?>
    <h3><?= $this->title ?></h3>

<?php
echo GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
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
                'attribute'       => 'status_id',
                'label'           => 'Статус',
                'format'          => 'raw',
                'filter'          => Select2::widget(
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
                'class'           => EditableColumn::class,
                'editableOptions' => [
                    'value'              => static function (User $model) {
                        return $model->status->name;
                    },
                    'asPopover'          => true,
                    'formOptions'        => [
                        'action' => Url::toRoute('change-status-user'),
                    ],
                    'displayValueConfig' => UserSearch::getStatuses(),
                    'inputType'          => Editable::INPUT_SELECT2,
                    'options'            => [
                        'data'       => UserSearch::getStatuses(),
                        'hideSearch' => true,
                    ],
                    'submitButton'       => [
                        'class' => 'btn btn-sm btn-success',
                        'icon'  => '<ion-icon name="add-outline" size="small"></ion-icon>',
                    ],
                    'resetButton'        => [
                        'icon' => '<ion-icon name="refresh-outline" size="small"></ion-icon>'
                    ],
                    'header'             => 'Статус'
                ],
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
                'template' => '{user-view}',
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
