<?php

namespace api\modules\v1\models\error;

use Exception;
use yii\web\HttpException;

class ValidationException extends HttpException
{
    public $firstErrors;

    public function __construct(
        array $firstErrors = [],
        $message = 'Ошибка валидации полей',
        $code = 0,
        Exception $previous = null
    )
    {
        $this->firstErrors = $firstErrors;
        parent::__construct(400, $message, $code, $previous);
    }
}
