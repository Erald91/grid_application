<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Record */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'qendra_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emertimi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_lindja')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nr_rendor')->textInput() ?>

    <?= $form->field($model, 'pranishem')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
