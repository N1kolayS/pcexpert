<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kind */

$this->title = 'Create Kind';
$this->params['breadcrumbs'][] = ['label' => 'Kinds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kind-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
