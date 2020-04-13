<?php


namespace backend\controllers\Moderator\Action;


use backend\controllers\Base\BaseAction;
use backend\controllers\Moderator\ModeratorController;
use backend\models\User\UserSearch;
use common\components\registry\RgUser;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * @property-read ModeratorController $controller
 */
class ActionUserList extends BaseAction
{
    /** @var UserSearch */
    public $userSearch;

    /** @var ActiveDataProvider */
    public $dataProvider;

    /**
     * @return string
     */
    public function run(): ?string
    {
        $this->controller->registerMeta('Пользователи', '', '');

        $request = Yii::$app->request;

        $searchModel = $this->getUserSearch(
            [
                'type_id' => RgUser::TYPE_BUSINESS
            ]
        );
        $searchModel->load($request->get());

        if ($searchModel->validate()) {
            $this->dataProvider = $this->getDataProvider(
                [
                    'query' => $searchModel->search()->getActiveQuery()
                ]
            );
        }

        return $this->controller->render(
            'user-list',
            [
                'searchModel'  => $searchModel,
                'dataProvider' => $this->dataProvider
            ]
        );
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getUserSearch(array $params)
    {
        return new $this->userSearch($params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function getDataProvider(array $params): ActiveDataProvider
    {
        return new $this->dataProvider($params);
    }


}