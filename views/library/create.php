<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Library */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Библиотеки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-success">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
