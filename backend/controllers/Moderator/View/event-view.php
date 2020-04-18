<?php
/**
 * @var View $this
 * @var Event $model
 */

use common\models\event\Event;
use yii\web\View;
use yii\widgets\DetailView;

$this->params['breadcrumbs'][] = ['label' => 'Список', 'url' => ['event-list']];
$this->params['breadcrumbs'][] = $this->title
?>
<?= DetailView::widget(
    [
        'model'      => $model,
        'attributes' => [
            'name'
        ]
    ]
)
?>

