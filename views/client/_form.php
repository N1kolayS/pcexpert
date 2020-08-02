<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="box-body">

    <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone', [
        'inputTemplate' => '<div class="input-group"><span class="input-group-addon">8</span>{input}</div>',
    ])->widget(\yii\widgets\MaskedInput::className(), [
        'name' => 'phone',
        'mask' => '999-999-9999',

    ]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'rating')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'legal')->textInput() ?>
</div>
<div class="box-footer">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
