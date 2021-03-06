<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\PersonPositionSalarySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="person-position-salary-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'position_id') ?>

    <?= $form->field($model, 'edoc_id') ?>

    <?= $form->field($model, 'adjust_date') ?>

    <?= $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'step') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'salary') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('andahrm', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('andahrm', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
