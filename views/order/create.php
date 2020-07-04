<?php

use app\models\CreateOrder;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use app\models\Order;

/* @var $this yii\web\View */
/* @var $model app\models\CreateOrder */

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
                <?= $form->field($model, 'client_fio')
                    ->textInput(['maxlength' => true, 'placeholder' => $model->attributeLabels()['client_fio'] ])->label(false) ?>

                <?= $form->field($model, 'client_phone')
                    ->textInput(['maxlength' => true, 'placeholder' => $model->attributeLabels()['client_phone'] ])->label(false) ?>

                <?= $form->field($model, 'client_comment')
                    ->textarea(['maxlength' => true, 'placeholder' => $model->attributeLabels()['client_comment'] ])->label(false) ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Оборудование</h3>
            </div>
            <div class="box-body">

                <?= $form->field($model, 'equipment_kind')
                    ->widget(Select2::classname(), [

                        'options' => ['placeholder' => 'Тип техники'],
                        'pluginOptions' => [
                            'tags' => true,
                            'minimumInputLength' => 1,
                            'language' => [
                                'errorLoading' => new JsExpression ("function () { return 'Поиск техники...'; }"),
                            ],
                            'ajax' => [
                                'url' => Url::to(['ajax-get-equipment-kind']),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                        ],
                    ])->label(false) ?>

                <?= $form->field($model, 'equipment_brand')
                    ->widget(Select2::classname(), [

                        'options' => ['placeholder' => 'Производитель'],
                        'pluginOptions' => [
                            'tags' => true,
                            'minimumInputLength' => 2,
                            'language' => [
                                'errorLoading' => new JsExpression ("function () { return 'Поиск производителей...'; }"),
                            ],
                            'ajax' => [
                                'url' => Url::to(['ajax-get-equipment-brand']),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                        ],
                    ])->label(false) ?>

                <?= $form->field($model, 'equipment_sample')
                    ->widget(Select2::classname(), [

                        'options' => ['placeholder' => 'Модель'],
                        'pluginOptions' => [
                            'tags' => true,
                            'minimumInputLength' => 2,
                            'language' => [
                                'errorLoading' => new JsExpression ("function () { return 'Поиск моделей...'; }"),
                            ],
                            'ajax' => [
                                'url' => Url::to(['ajax-get-equipment-sample']),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                        ],
                    ])->label(false) ?>

                <?= $form->field($model, 'serial_number')
                    ->textInput(['maxlength' => true, 'placeholder' => 'Серийный номер'])->label(false) ?>

                <?= $form->field($model, 'complect')
                    ->textInput(['maxlength' => true, 'placeholder' => $model->attributeLabels()['complect']])->label(false) ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Дополниельные сведения</h3>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'placement')
                    ->dropDownList(Order::listPlacement())->label(false) ?>
                <?= $form->field($model, 'prepayment')
                    ->textInput(['maxlength' => true, 'placeholder' => 'Предоплата'])->label(false) ?>

                <?= $form->field($model, 'comment')
                    ->textarea(['maxlength' => true, 'placeholder' => $model->attributeLabels()['comment'] ])->label(false) ?>

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Информация о проблеме</h3>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'problems')
                    ->textarea(['maxlength' => true, 'placeholder' => $model->attributeLabels()['problems'] ])->label(false) ?>


            </div>
        </div>
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