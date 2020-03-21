<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */

/** @var $model LoginForm */

use backend\models\Site\LoginForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h2><?= Html::encode($this->title) ?></h2>

    <p style="font-size: 15px;">Пожалуйста, заполните следующие поля для входа в систему:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($model, 'login')->textInput() ?>
            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox(['checked' => false]) ?>

            <?= \yii\bootstrap4\Html::submitButton(
                'Войти',
                [
                    'class' => 'btn btn-outline-success',
                ]
            ) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
