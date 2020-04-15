<?php


namespace backend\controllers\Moderator\Action\Event;


use backend\controllers\Base\BaseAction;
use backend\controllers\Moderator\ModeratorController;
use backend\models\Event\EventSearch;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * @property-read ModeratorController $controller
 */
class ActionEventList extends BaseAction
{
    /** @var EventSearch */
    public $eventSearch;

    /** @var ActiveDataProvider */
    public $dataProvider;

    public function run(): string
    {
        $this->controller->registerMeta('События', '', '');
        $request = Yii::$app->request;

        $searchModel = $this->getEventSearch();
        $searchModel->load($request->get());

        if ($searchModel->validate()) {
            $this->dataProvider = $this->getDataProvider(
                [
                    'query' => $searchModel->search()->getActiveQuery()
                ]
            );
        }

        return $this->controller->render(
            'event-list',
            [
                'searchModel'  => $searchModel,
                'dataProvider' => $this->dataProvider
            ]
        );
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function getDataProvider(array $params): ActiveDataProvider
    {
        return new $this->dataProvider($params);
    }

    /**
     * @return EventSearch
     */
    public function getEventSearch(): EventSearch
    {
        return new $this->eventSearch();
    }

}