<?php

namespace api\modules\v1\models\error;

class UnauthorizedHttpException extends HttpException
{
    public function __construct(array $firstErrors = [])
    {
        parent::__construct(401, $firstErrors, 'Ошибка авторизации', 0);
    }
}
