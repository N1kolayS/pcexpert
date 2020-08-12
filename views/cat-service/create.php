<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatService */

$this->title = 'Создать Катеогию услуг';
$this->params['breadcrumbs'][] = ['label' => 'Категория услуг', 'url' => ['index']];
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

