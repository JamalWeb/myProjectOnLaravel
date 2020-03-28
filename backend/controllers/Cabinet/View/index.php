<?php
/**
 * @var $this View
 * @var $profileForm ProfileForm
 */

use backend\models\Cabinet\ProfileForm;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\web\View;

?>
<div class="container bootstrap snippet">
    <div class="row">
        <div class="col-sm-10"><h1><?= $this->context->authorizedUser->username ?></h1></div>
    </div>
    <div class="row">
        <div class="col-sm-3"><!--left col-->
            <div class="text-center">
                <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail"
                     alt="avatar">
                <br>
                <br>
                <div class="custom-file">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                    <input type="file" class="custom-file-input" id="customFile">
                </div>
            </div>
            <br>
            <div class="card" style="">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Cras justo odio</li>
                    <li class="list-group-item">Dapibus ac facilisis in</li>
                    <li class="list-group-item">Vestibulum at eros</li>
                </ul>
            </div>
        </div><!--/col-3-->
        <div class="col-sm-9">
            <div class="card bg-light">
                <div class="card-header">Информация о пользователе</div>
                <div class="card-body">
                    <div class="tab-content">
                        <?php $form = ActiveForm::begin() ?>
                        <?= $form->field($profileForm, 'firstName')->textInput() ?>
                        <?= $form->field($profileForm, 'lastName')->textInput() ?>
                        <?= $form->field($profileForm, 'patronymic')->textInput() ?>
                        <?= $form->field($profileForm, 'gender')->textInput() ?>
                        <?= $form->field($profileForm, 'phoneNumber')->textInput() ?>
                        <?= $form->field($profileForm, 'address')->textInput() ?>
                        <?= $form->field($profileForm, 'username')->textInput() ?>
                        <?= $form->field($profileForm, 'email')->textInput() ?>
                        <?= $form->field($profileForm, 'role')->textInput(['disabled' => true]) ?>
                        <?= $form->field($profileForm, 'type')->textInput(['disabled' => true]) ?>
                        <?= $form->field($profileForm, 'createdAt')->textInput(['disabled' => true]) ?>

                        <?= Html::submitButton(
                            'Сохранить',
                            [
                                'class' => 'btn btn-outline-success',
                            ]
                        ) ?>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
