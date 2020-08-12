<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Template */

$this->title =  $model->name;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-info">
    <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'content')->widget(alexantr\ace\Ace::className(), [
            'mode' => 'php',
            //'presetPath' => '@backend/config/ace.php',
            'containerOptions' => [
                'style' => 'min-height:600px', // ...or this style

            ],
        ]) ?>


        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

