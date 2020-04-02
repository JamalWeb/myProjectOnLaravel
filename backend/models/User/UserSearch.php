<?php


namespace backend\models\User;


use common\components\ArrayHelper;
use common\models\user\User;
use common\models\user\UserGender;
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

    public static function getGenders(): array
    {
        return ArrayHelper::map(UserGender::find()->asArray()->all(), 'id', 'name');
    }

}
