<?php

namespace backend\models\User;

use common\components\ArrayHelper;
use common\models\user\User;
use common\models\user\UserGender;
use common\models\user\UserStatus;
use common\models\user\UserType;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\db\Query;

class UserSearch extends Model
{
    public $id;
    public $username;
    public $firstName;
    public $lastName;
    public $phone;
    public $gender_id;
    public $status_id;
    public $email;
    public $type_id;

    /** @var ActiveQuery */
    private $activeQuery;

    public function rules(): array
    {
        return [
            [
                [
                    'gender_id',
                    'id',
                    'status_id',
                    'type_id',
                ],
                'integer',
            ],
            [
                [
                    'username',
                    'firstName',
                    'lastName',
                    'phone',
                    'email',
                ],
                'string',
            ],
        ];
    }


    public function init(): void
    {
        $this->activeQuery = User::find()->alias('u');
    }

    public function search(): self
    {
        $this->activeQuery->andFilterWhere(
            [
                'status_id' => $this->status_id,
                'type_id'   => $this->type_id,
                'u.id'      => $this->id,
                'username'  => $this->username,
                'email'     => $this->email,
            ]
        );

        $this->activeQuery->joinWith(
            [
                'profile p' => function (Query $query) {
                    $query->andFilterWhere(['ilike', 'first_name', $this->firstName])
                        ->andFilterWhere(['ilike', 'last_name', $this->lastName])
                        ->andFilterWhere(['ilike', 'phone', $this->phone])
                        ->andFilterWhere(['gender_id' => $this->gender_id]);
                },
            ]
        );

        return $this;
    }

    /**
     * @return ActiveQuery
     */
    public function getActiveQuery(): ActiveQuery
    {
        return $this->activeQuery;
    }

    /**
     * @return array
     */
    public static function getGenders(): array
    {
        return ArrayHelper::map(UserGender::find()->asArray()->all(), 'id', 'name');
    }

    /**
     * @return array
     */
    public static function getTypes(): array
    {
        return ArrayHelper::map(UserType::find()->asArray()->all(), 'id', 'name');
    }

    /**
     * @param int $statusId
     * @return array
     */
    public static function getStatuses(int $statusId = null): array
    {
        return ArrayHelper::map(
            UserStatus::find()->filterWhere(['!=', 'id', $statusId])->asArray()->all(),
            'id',
            'name'
        );
    }
}
