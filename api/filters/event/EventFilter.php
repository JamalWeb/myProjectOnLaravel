<?php

namespace api\filters\event;

use common\models\event\Event;
use common\models\user\User;
use yii\base\Model;

/** @property Event $eventQuery */
class EventFilter extends Model
{
    /** @var array $interest IDS инетересов */
    public $interest;

    /** @var string */
    public $query;

    /** @var integer ID города */
    public $city;

    /** @var boolean Учитывать интересы пользователя */
    public $forYou;

    /** @var boolean Все события */
    public $all;

    /** @var string */
    public $dateFrom;

    /** @var string */
    public $dateTo;

    /** @var User */
    private $user;

    /** @var Event */
    private $eventQuery;

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
                'trueValue'  => true,
                'falseValue' => false
            ],
            [
                'all',
                'boolean',
                'trueValue'  => true,
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

    public function search()
    {


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

    /**
     * @return Event
     */
    public function getEventQuery(): Event
    {
        return $this->eventQuery;
    }

}