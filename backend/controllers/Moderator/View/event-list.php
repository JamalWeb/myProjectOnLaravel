<?php
/**
 * @var EventSearch $searchModel
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */

use backend\models\Event\EventSearch;
use common\components\ArrayHelper;
use common\models\event\Event;
use common\models\event\EventStatus;
use kartik\editable\Editable;
use kartik\grid\ActionColumn;
use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
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
                'format'    => 'html',
                'value'     => static function (Event $model) {
                    return Html::a(
                        $model->user->username ?? $model->user->email,
                        [
                            '/moderator/user-view',
                            'id' => $model->user->id,
                        ],
                        ['target' => '_blank']
                    );
                },
                'filter'    => Select2::widget(
                    [
                        'name'          => 'EventSearch[userId]',
                        'options'       => ['placeholder' => 'Введите (email,username,firstName)'],
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
            ],
            [
                'attribute'       => 'status_id',
                'label'           => 'Статус',
                'filter'          => Select2::widget(
                    [
                        'name'          => 'EventSearch[statusId]',
                        'data'          => EventSearch::getStatuses(),
                        'value'         => $searchModel->statusId,
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
                'editableOptions' => static function (Event $model) {
                    return [
                        'value'              => static function (Event $model) {
                            return ArrayHelper::getValue(
                                EventStatus::getList(),
                                $model->status_id
                            );
                        },
                        'asPopover'          => true,
                        'formOptions'        => [
                            'action' => Url::to(['change-status-event', 'id' => $model->id])
                        ],
                        'displayValueConfig' => EventSearch::getStatuses(),
                        'inputType'          => Editable::INPUT_SELECT2,
                        'options'            => [
                            'data'       => EventSearch::getStatuses(),
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
                    ];
                },
            ],
            [
                'class'    => ActionColumn::class,
                'template' => '{event-view}',
                'buttons'  => [
                    'event-view' => static function ($url) {
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
        ]
    ]
)

?>
