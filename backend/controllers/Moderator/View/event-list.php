<?php
/**
 * @var EventSearch $searchModel
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */

use backend\models\Event\EventSearch;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

//TODO Разработать уведомление о смене статуса бизнес профиля
//TODO Закончить с GridView Event
//TODO Закончить с DetailView Event
//TODO Разработать уведомление о смене статуса события
?>

<h3><?= $this->title ?></h3>

<?= GridView::widget(
    [
        'filterModel'  => $searchModel,
        'dataProvider' => $dataProvider,
        'columns'      => [
            'id',
            'name',
            [
                'attribute' => 'type_id',
                'header'    => 'Тип',
                'value'     => 'type_id',
                'filter'    => Select2::widget(
                    [
                        'name'          => 'EventSearch[typeId]',
                        'data'          => EventSearch::getEventTypes(),
                        'value'         => $searchModel->typeId,
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
            ],
            [
                'attribute' => 'user_id',
                'header'    => 'Создатель',
                'value'     => 'user.username',
                'filter'    => Select2::widget(
                    [
                        'name'          => 'EventSearch[userId]',
                        'options'       => ['placeholder' => 'Введите (email,username,firstName,id)'],
                        'pluginOptions' => [
                            'allowClear'         => true,
                            'minimumInputLength' => 1,
                            'ajax'               => [
                                'url'      => Url::to(['/moderator/user-list-filter']),
                                /** @see \backend\controllers\Moderator\Action\Event\ActionUserListFilter */
                                'dataType' => 'json',
                                'delay'    => 250,
                                'data'     => new JsExpression('function(params) { return {q:params.term}; }'),
                                'cache'    => true
                            ],
                            'escapeMarkup'       => new JsExpression('function (markup) { return markup; }'),
                            'templateResult'     => new JsExpression('function(user) { return user.text; }'),
                            'templateSelection'  => new JsExpression('function(user) { return user.text; }'),
                        ]
                    ]
                )
            ]
        ]
    ]
)

?>
