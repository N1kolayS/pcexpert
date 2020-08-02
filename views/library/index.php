<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LibrarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Библиотеки';
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
                    'attribute' => 'name',
                    'content' => function ($model) {
                        return Html::a($model->name, ['update', 'id' => $model->id]);
                    }
                ],
                [
                    'attribute' => 'type',
                    'content' => function ($model) {
                        return $model->typeLabel;
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

