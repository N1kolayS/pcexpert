<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\CatService;

/* @var $this yii\web\View */
/* @var $model app\models\Service */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>
<div class="box-body">

    <?= $form->field($model, 'category_id')
        ->dropDownList(ArrayHelper::map(CatService::listItems(), 'id', 'name'), ['prompt' => ' - Выберите категорию - ']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'duration')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantee')->textInput(['maxlength' => true]) ?>

</div>
<div class="box-footer">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
