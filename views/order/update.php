<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Library;
use yii\bootstrap\Modal;
use \app\models\Service;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Даныне о заявке №' . $model->id. ' от '. $model->created_at;
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Заявка';

$js = <<< JS
let cost = 0;
let modal_services = $("#modal_services");
let current_service = $("#current_service");
let totalCost = $("#totalCost");

$("#add_service").click(function() {
  modal_services.modal('show');
});

$(".service-add").click(function () {
    
    current_service.append('<tr>' +
     '<td><input type="hidden" name="Order[services][]" value="'+ $(this).data('id') +'" /> '+ $(this).data('name') +'</td>' +
     '<td>'+ $(this).data('guarantee') +'</td>' +
     '<td></td>' +
     '<td class="current_price" data-price="'+ $(this).data('price') +'">'+ $(this).data('price') +'</td>' +
     '<td><a role="button" class="delete-item"><span class="glyphicon glyphicon-remove"></span></a></td>' +
     '</tr>');
    countCost();
});

current_service.on('click', '.delete-item', function (){
   $(this).parent().parent().remove();
   countCost();
});

function countCost()
{
   
    $(".current_price").each(function (index, value) {
        let price = $(value).data('price');
        cost += +price;
        console.log(price);
    });
    totalCost.html(cost);
}
JS;

$this->registerJs($js);
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title"><?=$model->client->fio?></h3>
            <?=Html::a('<span class="glyphicon glyphicon-cog">', ['client/update', 'id' => $model->client_id], ['class' => 'pull-right btn btn-default'])?>
            </div>
            <div class="box-body">
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
                <p>Серийный номер <?=$model->equipment->serial_number?> </p>

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
                    ->textarea(['maxlength' => true, 'placeholder' => $model->attributeLabels()['comment'] ])->label(false) ?>

            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header">
                <a role="button" id="add_service" class="btn btn-info" >Добавить работу </a>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                    <tr>

                        <th>Работа, копмлектующие</th>
                        <th>Гарантия</th>
                        <th>Кол-во</th>
                        <th>Цена</th>
                        <th>#</th>
                    </tr>
                    </thead>
                    <tbody id="current_service">

                    </tbody>

                    <tfoot>
                    <tr>

                        <td></td>
                        <td>Итоговая сумма</td>
                        <td></td>
                        <td><span id="totalCost">0</span> </td>
                        <td></td>
                    </tr>
                    <tr>

                        <td></td>
                        <td>Внесенная предоплата</td>
                        <td></td>
                        <td><?= $form->field($model, 'prepayment')->textInput()->label(false) ?> </td>
                        <td></td>
                    </tr>
                    <tr>

                        <td></td>
                        <td>Конечная цена</td>
                        <td></td>
                        <td><?= $form->field($model, 'cost')->textInput()->label(false) ?> </td>
                        <td></td>
                    </tr>
                    <tr>

                        <td></td>
                        <td>Скидка</td>
                        <td></td>
                        <td><span>0</span> </td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-body">
                <?= $form->field($model, 'master_id')
                    ->dropDownList(ArrayHelper::map(\app\models\User::listActive(), 'id', 'username'))->label() ?>
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
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
