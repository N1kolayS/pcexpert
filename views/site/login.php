<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
    <div class="login-logo">
        <h1>PC Expert</h1>
    </div>

    <div class="login-box-body">

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',


    ]); ?>

        <?= $form->field($model, 'email', [
            'template' => '<div class="form-group has-feedback">{input}<span class="glyphicon glyphicon-envelope form-control-feedback"></span></div><p>{error}</p>',
        ])->textInput(['autofocus' => true, 'placeholder' => 'Email']) ?>

        <?= $form->field($model, 'password', [
            'template' => '<div class="form-group has-feedback">{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span></div><p>{error}</p>',
        ])->passwordInput(['placeholder' => 'Password']) ?>

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox([
                ]) ?>
            </div>
            <div class="col-xs-4">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-flat btn-block', 'name' => 'login-button']) ?>
            </div>
        </div>


    <?php ActiveForm::end(); ?>
    </div>

</div>
