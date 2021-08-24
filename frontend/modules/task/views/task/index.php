<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\icons\Icon;


/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\task\models\Task_Data_Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php 
    if(Yii::$app->user->can('admin')){
    
      echo  GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'custom_name',
            'custom_phone:ntext',
            'created_at',
            'task_date',
            'service_type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);}elseif (Yii::$app->user->can('team')) {
        # code...

        // query search tasks where task_id in user_task (user is login id = user_id) equale task id in task table
        $dataProvide = (new \yii\db\Query())
            ->select('task.*')
            ->from('task')
            ->innerJoin('usertask', 'usertask.task_id = task.id')
            ->where(['usertask.user_id' => Yii::$app->user->getId()])
            //->orWhere(['AND',['created_at' <= date('Y-m-d 00:00:00')],['created_at'<= '2021-08-26 00:00:00']])
            ->all();
            
        
        ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">custom_name</th>
                    <th scope="col">custom_phone</th>
                    <th scope="col">created_at</th>
                    <th scope="col">task_date</th>
                    <th scope="col">service_type</th>
                    <th scope="col">tools</th>
    
                    
    
                </tr>
            </thead>
            <tbody>
                        
                <?php foreach ($dataProvide as $data): ?>
                    <tr>
                        <td><?= $data['custom_name']  ?></td>
                        <td><?= $data['custom_phone']  ?></td>
                        <td><?= $data['created_at']  ?></td>
                        <td><?= $data['task_date']  ?></td>
                        <td><?= $data['service_type']  ?></td>
                        <td></td>
    
                    </tr>
                <?php endforeach;} ?>

            </tbody>
        </table>
     


</div>
