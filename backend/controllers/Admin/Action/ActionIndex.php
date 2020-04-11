<?php

namespace backend\controllers\Admin\Action;

use backend\controllers\Admin\AdminController;
use backend\controllers\Base\BaseAction;
use backend\models\User\UserSearch;
use Yii;
use yii\data\ActiveDataProvider;

/** @property-read AdminController $controller */
final class ActionIndex extends BaseAction
{
    /** @var UserSearch */
    public $modelSearch;

    public function run(): string
    {
        $this->controller->registerMeta("{$this->appName} | Список пользователей", '', '');

        $searchModel = $this->getModelSearch();
        $searchModel->load(Yii::$app->request->get());

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $searchModel->search()->getActiveQuery(),
            ]
        );

        return $this->controller->render(
            'index',
            [
                'dataProvider' => $dataProvider,
                'searchModel'  => $searchModel,
            ]
        );
    }

    /**
     * @return UserSearch
     */
    public function getModelSearch(): UserSearch
    {
        return new $this->modelSearch();
    }
}
