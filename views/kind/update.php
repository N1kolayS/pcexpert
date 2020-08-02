<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kind */

$this->title = 'Изменить: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Виды техники', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="box box-info">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

