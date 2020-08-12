<?php

use yii\helpers\Html;
use \richardfan\sortable\SortableGridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CatServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории услуг';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Создать категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="box-body">

        <?= SortableGridView::widget([
            'sortUrl' => Url::to(['sortItem']),
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'moveItem' => '.moveItem',
            'columns' => [
                [
                    'content' => function(){
                        return "<span class='glyphicon glyphicon-resize-vertical'></span>";
                    },
                    'contentOptions' => ['style'=>'cursor:move;', 'class' => 'moveItem'],
                ],
                'id',
                'name',
                //'sort',

                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                ],
            ],
        ]); ?>


    </div>
</div>
