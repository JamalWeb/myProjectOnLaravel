<?php

namespace api\modules\v1\handler;

use api\modules\v1\models\error\ValidationException;
use Error;
use Exception;
use yii\web\Response;

class ErrorHandler extends \yii\web\ErrorHandler
{
    /**
     * @param Error|Exception $exception
     * @throws Exception
     */
    protected function renderException($exception)
    {
        $response = new Response();
        $response->format = Response::FORMAT_JSON;
        $response->data = $this->convertExceptionToArray($exception);
        $response->setStatusCode(400);
        $response->send();
    }

    /**
     * @param Exception $exception
     * @return array|string
     * @throws Exception
     */
    protected function convertExceptionToArray($exception)
    {
        $error = [
            'type'    => $this->getClassName($exception),
            'message' => $exception->getMessage(),
            'errors'  => []
        ];

        if ($exception instanceof ValidationException) {
            $error['errors'] = $exception->firstErrors;
        }

        if (YII_DEBUG === true) {
            $error['file'] = $exception->getFile();
            $error['line'] = $exception->getLine();
        }

        return $error;
    }

    /**
     * @param $class
     * @return bool|string
     */
    private function getClassName($class)
    {
        $class = get_class($class);
        if ($pos = strrpos($class, '\\')) {
            return substr($class, $pos + 1);
        }

        return $class;
    }
}
