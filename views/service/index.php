<?php

use yii\helpers\Html;
use yii\grid\GridView;
use  \app\models\CatService;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Услуги';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Создать услугу', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="box-body">

        <?= GridView::widget([

            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,

            'columns' => [

                'id',
                [
                    'attribute' => 'category_id',
                    'filter'=> Html::activeDropDownList($searchModel,'category_id',
                        \yii\helpers\ArrayHelper::map(CatService::listItems(), 'id', 'name'),['class' => 'form-control', 'prompt' => 'Все']),
                    'content' => function (\app\models\Service $model) {
                        return $model->category->name;
                    }
                ],

                'name',
                'price',

                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                ],
            ],
        ]); ?>


    </div>
</div>
