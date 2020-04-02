<?php

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var UserSearch $searchModel
 */

use backend\models\User\UserSearch;
use common\models\user\User;
use kartik\select2\Select2;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\web\View;

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
                'value'     => static function (User $model) {
                    return $model->type->name;
                },
            ],
            [
                'attribute' => 'status',
                'value'     => static function (User $model) {
                    return $model->status->name;
                },
            ],
            [
                'attribute' => 'profile.gender_id',
                'label'     => 'Пол',
                'filter'    => Select2::widget(
                    [
                        'name'          => 'gender_id',
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
        ],
    ]
)
?>
