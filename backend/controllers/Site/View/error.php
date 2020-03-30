<?php

/* @var $this yii\web\View */

/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-2 text-center">
                <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/><?= nl2br(Html::encode($message)) ?></p>
            </div>
            <div class="col-md-10">
                <h3><?= Html::encode($this->title) ?>.</h3>
                <a class="btn btn-danger" href="javascript:history.back()">Go Back</a>
            </div>
        </div>
    </div>
</div>
