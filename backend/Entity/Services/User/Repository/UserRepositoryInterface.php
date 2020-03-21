<?php

namespace backend\Entity\Services\User\Repository;

interface UserRepositoryInterface
{
    public function save();

    public function get(string $field, $value);
}
