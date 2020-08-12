<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Service */

$this->title = 'Изменить: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Услуги', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title"><?=Html::encode($this->title)?></h3>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

