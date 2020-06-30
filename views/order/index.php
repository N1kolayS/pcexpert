<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Актуальные заявки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Создать заявку', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="box-body">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [


            'id',
            'created_at',
            'hired_at',
            'closed_at',
            'equipment_id',
            //'client_id',
            //'manager_id',
            //'master',
            //'status',
            //'placement',
            //'problems:ntext',
            //'complect',
            //'prepayment',
            //'cost',
            //'comment:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


    </div>
</div>
