<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Sample */
/* @var $form yii\widgets\ActiveForm */


?>

<?php $form = ActiveForm::begin(); ?>
<div class="box-body">

    <?= $form->field($model, 'brand_id')
        ->widget(Select2::classname(), [

            'options' => ['placeholder' => 'Производитель'],
            'initValueText' => (!empty($model->brand_id)) ? $model->brand->name : '',
            'pluginOptions' => [
                'tags' => true,
                'minimumInputLength' => 1,
                'language' => [
                    'errorLoading' => new JsExpression ("function () { return 'Поиск производителя...'; }"),
                ],
                'ajax' => [
                    'url' => Url::to(['ajax-get-brand']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
            ],
        ]) ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
</div>
<div class="box-footer">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
