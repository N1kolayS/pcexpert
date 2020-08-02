<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EquipmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Оборуование';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-body">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                'created_at',
                'client_id',
                'kind',
                'brand',
                'sample',
                'serial_number',
                //'description:ntext',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}'
                ],
            ],
        ]); ?>

    </div>
</div>