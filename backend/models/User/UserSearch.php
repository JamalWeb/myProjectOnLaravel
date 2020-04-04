<?php


namespace backend\models\User;


use common\components\ArrayHelper;
use common\models\user\User;
use common\models\user\UserGender;
use common\models\user\UserStatus;
use common\models\user\UserType;
use yii\base\Model;
use yii\db\ActiveQuery;

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
                    'status_d',
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


    public function init()
    {
        $this->activeQuery = User::find();
    }

    public function search(): self
    {
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
     * @return array
     */
    public static function getStatuses(): array
    {
        return ArrayHelper::map(UserStatus::find()->asArray()->all(), 'id', 'name');
    }

}
