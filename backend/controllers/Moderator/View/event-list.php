<?php
/**
 * @var EventSearch $searchModel
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */

use backend\models\Event\EventSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
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
                'value'     => 'type_id'
            ],
        ]
    ]
)

?>
