<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecordSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="record-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'qendra_id') ?>

    <?php echo $form->field($model, 'emertimi') ?>

    <?php //echo $form->field($model, 'date_lindja') ?>

    <?php echo $form->field($model, 'nr_rendor') ?>

    <?php echo $form->field($model, 'pranishem')->label('Paraqitur (1 or 0)') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        <?= Html::button('Clear', ['class' => 'btn btn-default clear-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

