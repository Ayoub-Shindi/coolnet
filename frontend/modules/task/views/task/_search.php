<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\task\models\Task_Data_Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'custom_name') ?>

    <?= $form->field($model, 'custom_phone') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'task_date') ?>

    <?php // echo $form->field($model, 'service_type') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
