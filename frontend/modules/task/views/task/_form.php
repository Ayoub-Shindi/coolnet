<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\usersmanager\models\User;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model frontend\modules\task\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
     $Follower = User::find()->all();
     $Follower = ArrayHelper::map($Follower,'id','username');
    ?>

    <?= $form->field($model,'Follower')->checkboxList($Follower); ?>

    <?= $form->field($model, 'custom_name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'custom_phone')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'task_date')
        ->textInput(['class' => 'form-control datePicker']) ?>



<?=
        \kato\DropZone::widget([
            'options' => [
                'maxFilesize' => '2',
                'url'=> \yii\helpers\Url::to(['task/upload']),  ///site/upload,,             'index.php?r=tasks/upload',

            ],
            'clientEvents' => [
                'complete' => "function(file){console.log(file)}",
                'removedfile' => "function(file){alert(file.name + ' is removed')}"
            ],
        ]);
    ?>


    <?= $form->field($model, 'service_type')->dropDownList([ 'Wi-Fi' => 'Wi-Fi', 'VDSL' => 'VDSL', 'ADSL' => 'ADSL', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php

$baseUrl = Yii::$app->urlManager->baseUrl;

//$this->registerJsFile($baseUrl."/js/jquery2.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerCssFile($baseUrl.'/js/bootstrap-datepicker.min.css', ['depends' => [\yii\bootstrap4\BootstrapAsset::className()]]);
$this->registerJsFile($baseUrl.'/js/bootstrap-datepicker.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile($baseUrl.'/js/jquery-clockpicker.min.css', ['depends' => [\yii\bootstrap4\BootstrapAsset::className()]]);
$this->registerJsFile($baseUrl.'/js/jquery-clockpicker.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$js = <<<js
    $('.datePicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
            todayHighlight: true
    });
    $('.clockpicker').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now',
        donetext: 'Done',
    }).find('input').change(function() {
        console.log(this.value);
    });
js;


$this->registerJs($js);
?>