<?php
/**
 * @var View $this
 * @var UserForm $model
 */

use backend\models\User\UserForm;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\web\View;

$this->params['breadcrumbs'][] = ['label' => 'Список', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title
?>

<div class="row">
    <div class="col-md-6">
        <h3><?= $this->title ?></h3>
    </div>
</div>

<div class="create-user-form">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'firstName')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'role')->widget(
        Select2::class,
        [
            'name'          => 'UserForm[role]',
            'data'          => UserForm::getRoles(),
            'options'       => [
                'class'       => 'form-control',
                'placeholder' => 'Выберите значение',
            ],
            'pluginOptions' => [
                'allowClear'    => true,
                'selectOnClose' => true,
            ],
        ]
    ) ?>
    <?= $form->field($model, 'genderId')->widget(
        Select2::class,
        [
            'name'          => 'UserForm[genderId]',
            'data'          => UserForm::getGenders(),
            'options'       => [
                'class'       => 'form-control',
                'placeholder' => 'Выберите значение',
            ],
            'pluginOptions' => [
                'allowClear'    => true,
                'selectOnClose' => true,
            ],

        ]
    ) ?>
    <?=
    Html::submitButton(
        'Создать',
        [
            'class' => 'btn btn-outline-success',
        ]
    )
    ?>
    <?php ActiveForm::end() ?>
</div>

