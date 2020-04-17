<?php


namespace backend\models\Event;


use common\components\ArrayHelper;
use common\models\event\Event;
use common\models\event\EventStatus;
use common\models\event\EventType;
use yii\base\Model;
use yii\db\ActiveQuery;

/**
 * @property ActiveQuery $activeQuery
 */
class EventSearch extends Model
{
    public $id;
    public $userId;
    public $statusId;
    public $name;
    public $cityId;
    public $typeId;
    public $interestCategoryId;

    private $activeQuery;

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        $this->activeQuery = Event::find();
    }

    public function rules(): array
    {
        return [
            [
                [
                    'id',
                    'userId',
                    'statusId',
                    'name',
                    'cityId',
                    'typeId',
                    'interestCategoryId'
                ],
                'integer',
            ],

            [
                'name',
                'string'
            ]
        ];
    }

    public function search(): self
    {
        $this->activeQuery->filterWhere(
            [
                'id'                   => $this->id,
                'user_id'              => $this->userId,
                'status_id'            => $this->statusId,
                'name'                 => $this->name,
                'city_id'              => $this->cityId,
                'type_id'              => $this->typeId,
                'interest_category_id' => $this->interestCategoryId
            ]
        );

        return $this;
    }

    /**
     * @return mixed
     */
    public function getActiveQuery(): ActiveQuery
    {
        return $this->activeQuery;
    }

    /**
     * @return array|array[]
     */
    public static function getEventTypes(): array
    {
        return ArrayHelper::map(EventType::getList(), 'id', 'name');
    }

    /**
     * @return array|array[]
     */
    public static function getStatuses(): array
    {
        return ArrayHelper::map(EventStatus::getList(), 'id', 'name');
    }
}