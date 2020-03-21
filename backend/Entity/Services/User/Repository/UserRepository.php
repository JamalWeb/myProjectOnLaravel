<?php


namespace backend\Entity\Services\User\Repository;


use yii\db\Connection;

class UserRepository implements UserRepositoryInterface
{
    private $connnection;

    public function __construct(Connection $connection)
    {
        $this->connnection = $connection;
    }


    public function save()
    {
    }

    public function get(string $field, $value)
    {
    }
}