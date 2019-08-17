<?php

namespace api\modules\v1\models\error;

class HttpException extends \yii\web\HttpException
{
    public $firstErrors;

    public function __construct(int $status, array $firstErrors = [], string $message = 'Ошибка', int $code = 0)
    {
        $this->firstErrors = $firstErrors;

        parent::__construct($status, $message, $code, null);
    }
}
