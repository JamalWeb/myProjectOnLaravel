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

    /** @var integer ID города */
    public $city;

    /** @var boolean Учитывать интересы пользователя */
    public $forYou;

    /** @var string */
    public $dateFrom;

    /** @var string */
    public $dateTo;

    /** @var Event */
    private $eventQuery;

    /** @var User $user */
    private $user;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                'interest',
                'safe'
            ],
            [
                'query',
                'string',
                'max' => 255
            ],
            [
                'city',
                'integer'
            ],
            [
                'forYou',
                'boolean',
                'trueValue' => true,
                'falseValue' => false
            ],
            [
                'all',
                'boolean',
                'trueValue' => true,
                'falseValue' => false
            ],
            [
                [
                    'dateFrom',
                    'dateTo'
                ],
                'date'
            ],
        ];
    }

    public function init(): void
    {
        $this->eventQuery = Event::find();
    }

    public function search(): EventFilter
    {
        if (!empty($this->query)) {
            $this->eventQuery->andFilterWhere(['ilike', 'name', $this->query]);
        }

        if (!empty($this->interest)) {
            $this->eventQuery->andWhere(['in', 'interest_category_id', ArrayHelper::jsonToArray($this->interest)]);
        }

        if ($this->forYou) {
            $userInterest = $this->user->getRelationUserInterests()->select(['interest_category_id'])->column();
            if (empty($userInterest)) {
                throw new NotFoundHttpException('Not found interest');
            }

            $this->eventQuery->andFilterWhere(['in', 'interest_category_id', $userInterest]);
        }

        if ($this->city) {
            $this->eventQuery->andWhere(['city_id' => $this->city]);
        }

        return $this;
    }

    /**
     * @return ActiveQuery
     */
    public function getEventQuery(): ActiveQuery
    {
        return $this->eventQuery;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

}