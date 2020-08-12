<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Актуальные заявки';
$this->params['breadcrumbs'][] = $this->title;

$css = <<<CSS
#date_range
{
    padding-left: 2px !important;
    padding-right: 0 !important;
}

CSS;
$this->registerCss($css);

?>
<div class="box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Создать заявку', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="box-body">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'=>function (\app\models\Order  $model, $key, $index, $grid) {
            return [
                'class'=> $model->statusColor
            ];
        },
        'columns' => [
            [
                'attribute' => 'id',
                'options' => ['width' => 50]
            ],
            [
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_range',
                    'startAttribute' => 'date_from',
                    'endAttribute' => 'date_to',
                    'convertFormat'=>true,
                    'options' => ['placeholder' => 'Выберите даты...', 'id' => 'date_range', 'class' => 'form-control'],
                    'pluginEvents' => [
                        "cancel.daterangepicker" => "function(ev, picker) {
                            var poleDate = picker.element[0].nextElementSibling;
                            $(date_range).val('').trigger('change');
                            }",
                    ],
                    'pluginOptions'=>[
                        'locale'=>['format'=>'Y-m-d',  'cancelLabel' => 'Очистить']
                    ]
                ]),
                'attribute' => 'created_at',
                'format' =>  ['date', 'php:d M Y H:i'],
                'options' => ['width' => '185']
            ],
            [
                'attribute' => 'equipment_kind',
                'content' => function ($model) {
                    return $model->equipment->kind;
                }
            ],
            [
                'attribute' => 'equipment_brand',
                'content' => function ($model) {
                    return $model->equipment->brand;
                }
            ],
            [
                'attribute' => 'equipment_sample',
                'content' => function ($model) {
                    return $model->equipment->sample;
                }
            ],
            [
                'attribute' => 'client_fio',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'client_fio',
                    'initValueText' => ($searchModel->client) ? $searchModel->client->fio : '',
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => [
                        'placeholder' => 'ФИО клиента',
                        'multiple' => false,
                    ],
                    'hideSearch' => false,
                    'pluginOptions' => [
                        'tags' => true,
                        'allowClear' => true,
                        'minimumInputLength' => 2,
                        'language' => [
                            'errorLoading' => new JsExpression ("function () { return 'Поиск клиента...'; }"),
                        ],
                        'ajax' => [
                            'url' => Url::to(['client/ajax-get']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ],
                ]),
                'content' => function (\app\models\Order $model) {
                    return $model->client->fio;
                }
            ],
            [
                'attribute' => 'client_phone',
                'content' => function (\app\models\Order $model) {
                    return $model->client->phoneFormat;
                }
            ],
            'comment',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {print}',
                'buttons' => [
                        'print' => function($url,$model,$key){
                            return Html::a('<span class="glyphicon glyphicon-print"></span>',
                                ['print/order', 'id' => $model->id],
                            ['onclick' => "window.open(this.href, 'Печать Акта', 'height=600, width=800,toolbar=0,location=0,menubar=0'); return false;"]);
                    }
                ]
            ],



        ],
    ]); ?>


    </div>
</div>
