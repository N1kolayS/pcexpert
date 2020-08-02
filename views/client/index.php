<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Клиенты';
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

                [
                    'attribute' => 'id',
                    'options' => ['width' => 50]
                ],
                'created_at',
                [
                    'attribute' => 'fio',

                    'filter' => Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'fio',

                        'theme' => Select2::THEME_BOOTSTRAP,
                        'options' => [
                            'placeholder' => 'ФИО',
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
                                'url' => Url::to(['ajax-get']),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                        ],

                    ]),

                    'content' => function ($model) {
                        return Html::a($model->fio, ['update','id' => $model->id]);
                    }
                ],
                [
                    'attribute' => 'phone',
                    'content' => function ($model) {
                        return Html::a($model->phoneFormat, 'tel:8'.$model->phone);
                    }
                ],
                [
                        'attribute' => 'creator_id',
                    'content' => function ($model) {
                        return $model->creator->username;
                    }],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}'
                ],
            ],
        ]); ?>

    </div>
</div>
