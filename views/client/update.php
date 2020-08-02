<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Client */

$this->title = 'Изменить : ' . $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];

$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="box box-info">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
