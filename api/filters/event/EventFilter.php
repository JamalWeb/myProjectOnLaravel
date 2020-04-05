<?php

namespace api\filters\event;

use common\components\ArrayHelper;
use common\models\event\Event;
use common\models\user\User;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;

/** @property ActiveQuery $eventQuery */
class EventFilter extends Model
{
    /** @var string $interest IDS инетересов */
    public $interest;

    /** @var string */
    public $query;

    /** @var int ID города */
    public $city;

    /** @var bool Учитывать интересы пользователя */
    public $forYou;

    /** @var string */
    public $dateFrom;

    /** @var string */
    public $dateTo;

    /** @var Event */
    private $eventQuery;

    /** @var User $user */
    private $user;

    public function __construct(User $user, $config = [])
    {
        parent::__construct($config);
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                'interest',
                'safe',
            ],
            [
                'query',
                'string',
                'max' => 255,
            ],
            [
                'city',
                'integer',
            ],
            [
                'forYou',
                'boolean',
                'trueValue'  => true,
                'falseValue' => false,
            ],
            [
                'all',
                'boolean',
                'trueValue'  => true,
                'falseValue' => false,
            ],
            [
                [
                    'dateFrom',
                    'dateTo',
                ],
                'date',
            ],
        ];
    }

    public function init(): void
    {
        $this->eventQuery = Event::find();
    }

    public function search(): EventFilter
    {
        $this->eventQuery->andFilterWhere(
            [
                'OR',
                ['ilike', 'address', $this->query],
                ['ilike', 'name', $this->query],
            ]
        );

        $this->eventQuery->andFilterWhere(
            ['in', 'interest_category_id', ArrayHelper::jsonToArray($this->interest)]
        );


        if ($this->forYou) {
            $userInterest = $this->user->getRelationUserInterests()->select(['interest_category_id'])->column();
            if (empty($userInterest)) {
                throw new NotFoundHttpException('Not found interest');
            }

            $this->eventQuery->andFilterWhere(['in', 'interest_category_id', $userInterest]);
        }

        if (is_int($this->city)) {
            $this->eventQuery->andFilterWhere(['city_id' => $this->city]);
        }

        $this->addOrderBy();
        return $this;
    }

    public function addOrderBy(): void
    {
        $this->eventQuery->addOrderBy(['created_at' => SORT_DESC]);
    }

    /**
     * @return ActiveQuery
     */
    public function getEventQuery(): ActiveQuery
    {
        return $this->eventQuery;
    }
}
