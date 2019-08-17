<?php

namespace api\modules\v1\models\error;

class BadRequestHttpException extends HttpException
{
    public function __construct(array $firstErrors = [])
    {
        parent::__construct(400, $firstErrors, 'Неправильный запрос', 0);
    }
}
