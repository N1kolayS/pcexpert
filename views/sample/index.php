<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SampleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Модели';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="box-body">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [

                'id',
                [
                    'attribute' => 'brand_id',
                    'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'brand_id',
                    'initValueText' => (!empty($searchModel->brand_id)) ? $searchModel->brand->name : '',
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => [
                        'placeholder' => 'Производитель',
                        'multiple' => false,
                    ],
                    'hideSearch' => false,
                    'pluginOptions' => [
                        'tags' => true,
                        'allowClear' => true,
                        'minimumInputLength' => 2,
                        'language' => [
                            'errorLoading' => new JsExpression ("function () { return 'Поиск производителя...'; }"),
                        ],
                        'ajax' => [
                            'url' => Url::to(['ajax-get-brand']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ],
                ]),
                    'content' => function ($model) {
                        return $model->brand->name;
                    }
                ],
                [
                    'attribute' => 'name',
                    'content' => function ($model) {
                        return Html::a($model->name, ['update', 'id' => $model->id]);
                    }
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}'
                ],
            ],
        ]); ?>

    </div>
</div>
