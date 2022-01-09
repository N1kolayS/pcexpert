<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use \app\models\Service;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Данные о заявке №' . $model->id. ' от '. $model->created_at;
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Заявка';

$prepayment = $model->prepayment ?: 0;
$cost  = $model->cost ?: 0;
$data_service = ($model->services) ?: '[]';
$js = <<< JS
const DATA_SERVICE = $data_service
const CURRENT_SERVICE = $("#current_service");
const TOTAL_COST = $("#totalCost");

const SERVICE_NAME      = $("#service_name");
const SERVICE_GUARANTEE = $("#service_guarantee");

const SERVICE_PRICE     = $("#service_price");
const BTN_ADD_SERVICE   = $("#btn_add_service");

let prepayment = $prepayment;
let order_cost = $("#order-cost");

let service_counter = 0;

$( document ).ready(function() {
    console.log(DATA_SERVICE)
    try {
      
      $.each(DATA_SERVICE, function (index, value) {
        addService(value.name, value.guarantee, value.price)  
    });
    }
    catch (e) {
      console.log(e)
    }
    countCost();
});

CURRENT_SERVICE.on('click', '.delete-item', function (){
   $(this).parent().parent().remove();
   countCost();
});

BTN_ADD_SERVICE.click(function(e) {
    e.preventDefault()
  addService(SERVICE_NAME.val(), SERVICE_GUARANTEE.val(), SERVICE_PRICE.val())  
  $(".service-input").val('')
  countCost();
});

function addService(name, guarantee, price) {
  service_counter++;
  CURRENT_SERVICE.append(`<tr>
  <td><input type="hidden"  name="Order[service][`+service_counter+`][name]" value="` + name +`" />` + name +`</td>
  <td><input type="hidden"  name="Order[service][`+service_counter+`][guarantee]" value="` + guarantee +`" />` + guarantee +`</td>
  
  <td class="current_price" data-price="` + price +`">
  <input type="hidden"  name="Order[service][`+service_counter+`][price]" value="` + price +`" />` + price +`</td>
  <td><a role="button" class="delete-item"><span class="glyphicon glyphicon-remove"></span></a></td>
  </tr>`)
}

/**
* 
* @param data
*/
function setService(data) {
    SERVICE_GUARANTEE.val(data.guarantee);
    
    SERVICE_PRICE.val(data.price);
}

function countCost()
{
   let cost =0;
    $(".current_price").each(function (index, value) {
        let price = $(value).data('price');
        cost += +price;
        console.log(price);
    });
    let total = cost - prepayment;
    TOTAL_COST.html(cost);
    order_cost.val(total);
}
JS;

$css = <<<CSS
.col-count {
    width: 100px;
}
.col-price {
    width: 100px;
}

.col-guarantee {
    width: 200px;
}
CSS;

$this->registerCss($css);
$this->registerJs($js);
?>
<?php $form = ActiveForm::begin(['id' => 'form_order']); ?>
<div class="row">
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title"><?=$model->client->fio?></h3>

            <?=Html::a('<span class="glyphicon glyphicon-cog">', ['client/update', 'id' => $model->client_id], ['class' => 'pull-right btn btn-default'])?>
            </div>
            <div class="box-body">
                <p><?=$model->client->comment?></p>
                <p> <span class=" glyphicon glyphicon-earphone "></span> <?=$model->client->phoneFormat?> </p>
            </div>
        </div>
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title"><?=$model->equipment->kind?> <?=$model->equipment->brand?> <?=$model->equipment->sample?></h3>
                <?=Html::a('<span class="glyphicon glyphicon-cog">', ['equipment/update', 'id' => $model->equipment_id], ['class' => 'pull-right btn btn-default'])?>
            </div>
            <div class="box-body">

                <?= $form->field($model, 'kit')->textInput(['maxlength' => true])->label(false) ?>
                <p>Серийный номер <strong><?=$model->equipment->serial_number?></strong>  </p>

                <?= $form->field($model, 'problems')->textInput(['maxlength' => true])->label(false)
                ?>
            </div>
        </div>

        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Статус</h3>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'status')
                    ->radioList($model::listStatus())->label(false) ?>

                <?= $form->field($model, 'placement')
                    ->dropDownList($model::listPlacement())->label(false) ?>

                <?= $form->field($model, 'comment')
                    ->textarea(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('comment') ])->label(false) ?>

            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="box box-primary">

            <div class="box-body">
                <table class="table">
                    <thead>
                    <tr>
                        <td>
                            <?= AutoComplete::widget([
                                'clientOptions' => [
                                    'source' => Url::to(['ajax-get-services']),
                                    'minLength' => 2,
                                    'select' =>new JsExpression('function(event, ui) {
                                this.value = ui.item.name;
                                setService(ui.item)
                                return false;
                            }')
                                ],
                                'options' => [
                                    'class' => 'form-control service-input',
                                    'id' => 'service_name',
                                    'placeholder' => 'Введите работы',
                                ]
                            ]);
                            ?>
                        </td>
                        <td><input type="text" placeholder="Гарантия" class="form-control service-input" id="service_guarantee" > </td>
                        <td><input type="text" placeholder="Цена"     class="form-control service-input" id="service_price" > </td>
                        <td><button class="btn btn-sm btn-success" id="btn_add_service"> <span class="glyphicon glyphicon-plus"></span> </button> </td>

                    </tr>
                    <tr>
                        <th>Работа, комплектующие</th>
                        <th class="col-guarantee">Гарантия</th>

                        <th class="col-price">Цена</th>
                        <th>#</th>
                    </tr>
                    </thead>
                    <tbody id="current_service">

                    </tbody>
                    <tfoot>
                    <tr>

                        <td></td>
                        <td>Итоговая сумма</td>

                        <td><span id="totalCost"><?=array_sum(ArrayHelper::getColumn($model->service, 'price'))?></span> </td>
                        <td></td>
                    </tr>
                    <tr>

                        <td></td>
                        <td>Внесенная предоплата</td>

                        <td><?= $form->field($model, 'prepayment')->textInput()->label(false) ?> </td>
                        <td></td>
                    </tr>
                    <tr>

                        <td></td>
                        <td>Конечная цена</td>

                        <td><?= $form->field($model, 'cost')->textInput()->label(false) ?> </td>
                        <td></td>
                    </tr>
                    <tr>

                        <td></td>
                        <td>Скидка</td>

                        <td><span>0</span> </td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Оформил <?=$model->manager->username?></h3>
            </div>
            <div class="box-body">
                <strong><?=$model->problems?></strong>
                <hr />

                <?= $form->field($model, 'master_id')
                    ->dropDownList(ArrayHelper::map(\app\models\User::listActive(), 'id', 'username'))->label() ?>

                <?= $form->field($model, 'conclusion')
                    ->textarea(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('conclusion') ])->label(false) ?>

                <?= $form->field($model, 'recommendation')
                    ->textarea(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('recommendation') ])->label(false) ?>
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?=Html::hiddenInput('print_act', 0, ['id' => 'print_act'])?>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

        <?= Html::button('Сохранить и напечатать чек',
            ['class' => 'btn btn-primary pull-right', 'onclick' => "$('#print_act').val(1);document.forms['form_order'].submit();"]) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>



<?php Modal::begin([
    'options'=> [
        'id'=>'modal_services',
    ],
]);
?>

<table class="table table-hover">
    <thead>
    <tr>
        <th>Название</th>
        <th>Гарантия</th>
        <th>Стоимость</th>
        <th> - </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach (Service::listItems() as $service): ?>
    <tr>
        <td><?=$service->name?></td>
        <td><?=$service->guarantee?></td>
        <td><?=$service->price?></td>
        <td><a role="button" class="btn btn-success btn-sm service-add"
               data-id="<?=$service->id?>"
               data-name="<?=$service->name?>"
               data-guarantee="<?=$service->guarantee?>"
               data-price="<?=$service->price?>"
            >Добавить </a> </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php Modal::end(); ?>
