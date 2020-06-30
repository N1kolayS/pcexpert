<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Создать Заказ';
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Клиент</h3>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'client_fio')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'client_phone')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'client_comment')->textarea(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">

    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>