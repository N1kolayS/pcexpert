<?php

use app\models\CreateOrder;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use app\models\Order;
use yii\jui\AutoComplete;
use yii\helpers\ArrayHelper;
use app\models\Library;

/* @var $this yii\web\View */
/* @var $model app\models\CreateOrder */

$this->title = 'Создать Заказ';
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$route_AjaxGetClients =  Url::to(['ajax-get-clients']);
$js = <<< JS
let client_id  = $("#createorder-client_id");
let client_fio  = $("#createorder-client_fio");
let client_phone  = $("#createorder-client_phone");
let client_comment = $("#createorder-client_comment");
let btn_reset_client = $("#btn_reset_client");
let equipment_kind = $("#createorder-equipment_kind");
let equipment_brand = $("#createorder-equipment_brand");
let equipment_sample = $("#createorder-equipment_sample");
let equipment_serial_number = $("#createorder-equipment_serial_number");
let brand_id;

    function setClient(item) {
        client_id.val(item.id);
        client_phone.val(item.phone);
        client_comment.val(item.comment);
        btn_reset_client.attr("disabled", false);
        btn_reset_client.removeClass('btn-default');
        btn_reset_client.addClass('btn-warning');
        client_fio.attr("readonly", true);
        client_phone.attr("readonly", true);
        client_comment.attr("readonly", true);
        equipment_kind.focus();
        console.log(item);
    }
btn_reset_client.click(function () {
    client_id.val('');
    btn_reset_client.attr("disabled", true);
    btn_reset_client.removeClass('btn-warning');
    btn_reset_client.addClass('btn-default');
    client_fio.attr("readonly", false);
    client_phone.attr("readonly", false);
    client_comment.attr("readonly", false);
});
JS;

$this->registerJs($js);

$css = <<<CSS
#block_reset_client {

}
CSS;

$this->registerCss($css);
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Клиент</h3>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'client_fio', [
                    'inputTemplate' => '<div class="input-group">{input}<span class="input-group-btn"><button class="btn btn-default"  id="btn_reset_client" disabled type="button">X</button> </span></div>',
                ])
                    ->widget(AutoComplete::classname(), [
                        'clientOptions' => [
                            'source' => Url::to(['ajax-get-clients']),
                            'minLength' => 2,
                            'select' =>new JsExpression('function(event, ui) {
                                this.value = ui.item.fio;
                                setClient(ui.item)
                                return false;
                            }')
                        ],

                        'options' => [
                            'autofocus'=>'autofocus',
                            'class' => 'form-control',
                            'placeholder' => $model->getAttributeLabel('client_fio'),

                            ]
                    ])->label(false) ?>

                <?= $form->field($model, 'client_phone',  [
                    'inputTemplate' => '<div class="input-group"><span class="input-group-addon">8</span>{input}</div>',
                ])
                    ->widget(\yii\widgets\MaskedInput::className(), [
                        'name' => 'client_phone',
                        'mask' => '999-999-9999',
                        'options' => ['placeholder' => $model->getAttributeLabel('client_phone')]

                    ])->label(false) ?>

                <?= $form->field($model, 'client_comment')
                    ->textarea(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('client_comment') ])->label(false) ?>

                <?=$form->field($model,'client_id')->hiddenInput()->label(false)?>
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
                    ->widget(AutoComplete::classname(), [
                        'clientOptions' => [
                            'source' => Url::to(['ajax-get-equipment-kind']),
                            'select' =>new JsExpression('function(event, ui) {
                                this.value = ui.item.label;
                                equipment_brand.focus();
                                return false;
                            }'),
                            'minLength' => 2,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => $model->getAttributeLabel('equipment_kind'),

                        ]
                    ])->label(false) ?>

                <?= $form->field($model, 'equipment_brand')
                    ->widget(AutoComplete::classname(), [
                        'clientOptions' => [
                            'source' => Url::to(['ajax-get-equipment-brand']),
                            'minLength' => 2,
                            'select' =>new JsExpression('function(event, ui) {
                                this.value = ui.item.label;
                                brand_id = ui.item.id;
                                equipment_sample.focus();
                                return false;
                            }')
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => $model->getAttributeLabel('equipment_brand'),

                        ]
                    ])->label(false) ?>

                <?= $form->field($model, 'equipment_sample')
                    ->widget(AutoComplete::classname(), [
                        'clientOptions' => [
                            'source' =>new JsExpression('function(request, response) {
                            $.getJSON("'. Url::to(['ajax-get-equipment-sample']).'", {
                                term: request.term.split(/,s*/).pop(),
                                brand_id: brand_id
                            }, response);
                        }'),

                            'minLength' => 2,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => $model->getAttributeLabel('equipment_sample'),

                        ]
                    ])->label(false) ?>

                <?= $form->field($model, 'equipment_serial_number')
                    ->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('equipment_serial_number')])->label(false) ?>

                <?= $form->field($model, 'kit')
                    ->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Library::listKits(), 'name','name'),
                        'options' => [
                                'placeholder' => $model->getAttributeLabel('kit'),
                            'multiple'=>true
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'tags' => true,
                            'tokenSeparators' => [',', '.'],
                        ],
                    ])->label(false) ?>
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
                    ->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Library::listProblems(), 'name','name'),
                        'options' => [
                            'placeholder' => $model->getAttributeLabel('problems'),
                            'multiple'=>true
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'tags' => true,
                            'tokenSeparators' => [',', '.'],
                        ],
                    ])->label(false)
                     ?>


            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?=var_dump($model->errors)?>
        <div class="form-group">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>