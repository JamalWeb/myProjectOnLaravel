<?php

namespace backend\controllers\Confirm;

use backend\controllers\Base\BaseController;
use backend\controllers\Confirm\Action\ActionEmail;
use backend\controllers\Confirm\models\VerifyEmailForm;
use backend\Entity\Services\User\AuthService;

class ConfirmController extends BaseController
{
    public $service;

    /**
     * ConfirmController constructor.
     * @param $id
     * @param $module
     * @param AuthService $service
     * @param array $config
     */
    public function __construct($id, $module, AuthService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actions()
    {
        return [
            'email' => [
                'class' => ActionEmail::class,
                'form'  => VerifyEmailForm::class,
            ],
        ];
    }
}
