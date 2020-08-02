<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kind */

$this->title = 'Создать  вид техники';
$this->params['breadcrumbs'][] = ['label' => 'Виды техники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-success">
    <div class="box-header">
        <h3 class="box-title"><?=Html::encode($this->title)?></h3>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
