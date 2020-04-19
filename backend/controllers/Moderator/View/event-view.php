<?php
/**
 * @var View $this
 * @var Event $model
 */

use backend\models\Event\EventSearch;
use common\components\ArrayHelper;
use common\models\event\Event;
use common\models\event\EventStatus;
use kartik\editable\Editable;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

$this->params['breadcrumbs'][] = ['label' => 'Список', 'url' => ['event-list']];
$this->params['breadcrumbs'][] = $this->title
?>

<div class="row">
    <div class="col-md-6">
        <h3><?= $this->title ?></h3>
    </div>
    <div class="col-md-6 text-right">
        <?php
        $eventStatuses = EventSearch::getStatuses();
        echo Editable::widget(
            [
                'model'              => $model,
                'attribute'          => 'status_id',
                'value'              => ArrayHelper::getValue(EventStatus::getList(), $model->status_id),
                'asPopover'          => true,
                'header'             => 'Статус',
                'inputType'          => Editable::INPUT_SELECT2,
                'options'            => [
                    'data'       => $eventStatuses,
                    'hideSearch' => true,
                    'class'      => 'form-control',
                    'name'       => 'User',
                ],
                'formOptions'        => [
                    'action' => Url::toRoute(['change-status-event', 'id' => $model->id]),
                ],
                'displayValueConfig' => $eventStatuses,
                'submitButton'       => [
                    'class' => 'btn btn-sm btn-success',
                    'icon'  => '<ion-icon name="add-outline" size="small"></ion-icon>',
                ],
                'resetButton'        => [
                    'icon' => '<ion-icon name="refresh-outline" size="small"></ion-icon>'
                ],

            ]
        )
        ?>
    </div>
</div>

<?= DetailView::widget(
    [
        'model'      => $model,
        'attributes' => [
            'name'
        ]
    ]
)
?>

