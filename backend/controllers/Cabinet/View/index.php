<?php

/**
 * @var $this View
 * @var $profileForm ProfileForm
 */


use backend\assets\AppAsset;
use backend\models\Cabinet\ProfileForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

$this->registerJsFile(
    '@web/js/cabinet/update.js',
    [
        'position' => View::POS_END,
        'depends'  => [AppAsset::class],
    ]
);
?>
<div class="container bootstrap snippet">
    <div class="row">
        <div class="col-sm-10"><h1><?= $this->context->authorizedUser->username ?></h1></div>
    </div>
    <div class="row">
        <div class="col-sm-3"><!--left col-->
            <div class="text-center">

            </div>
        </div><!--/col-3-->
        <div class="col-sm-9">
            <div class="card bg-light">
                <div class="card-header">Информация о пользователе</div>
                <div class="card-body">
                    <div class="tab-content">
                        <?php $form = ActiveForm::begin(
                            [
                                'id'                     => 'profileForm',
                                'action'                 => Url::to(['update-profile']),
                                'enableClientValidation' => true,
                                'enableAjaxValidation'   => true,
                            ]
                        ) ?>
                        <?= $form->field($profileForm, 'firstName')->textInput() ?>
                        <?= $form->field($profileForm, 'lastName')->textInput() ?>
                        <?= $form->field($profileForm, 'patronymic')->textInput() ?>
                        <?= $form->field($profileForm, 'genderId')->dropDownList(ProfileForm::getGenders()) ?>
                        <?= $form->field($profileForm, 'phoneNumber')->textInput() ?>
                        <?= $form->field($profileForm, 'address')->textInput() ?>
                        <?= $form->field($profileForm, 'username')->textInput() ?>
                        <?= $form->field($profileForm, 'email')->textInput() ?>
                        <?= $form->field($profileForm, 'role')->textInput(['disabled' => true]) ?>
                        <?= $form->field($profileForm, 'type')->textInput(['disabled' => true]) ?>
                        <?= $form->field($profileForm, 'createdAt')->textInput(['disabled' => true]) ?>
                        <hr>
                        <h3>Сменить пароль</h3>
                        <?= $form->field($profileForm, 'currentPassword')->passwordInput() ?>
                        <?= $form->field($profileForm, 'newPassword')->passwordInput() ?>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
