<?php

namespace frontend\modules\task\controllers;
use Yii;
use frontend\modules\task\models\Task;
use frontend\modules\task\models\Task_Data_Search;
use frontend\modules\usersmanager\models\Usertask;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new Task_Data_Search();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can( 'admin' )){
            //new model
            $model = new Task();
            $model->created_at = date("y-m-d");

        
            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {
                    $follow = $_POST['Task']['Follower'];
                    
                    $model->save(false);
                    //get last id inserted in task table
                    $xid = Yii::$app->db->getLastInsertID();
    
                    //save users id and task id in (usertask) table
                    foreach ($follow as $value) {
                        # code...
                        //new newUserTask
                        $newUserTask = new Usertask();
                        $newUserTask->user_id = $value;
                        $newUserTask->task_id = $xid;
                        $newUserTask->save(false);
                    }

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $model->loadDefaultValues();
            }

            return $this->render('create', [
                'model' => $model,
            ]);

        }else{
            throw new ForbiddenHttpException('You are not allowed to access');
        }
        
    }


    public function actionUpload()
    {
        $fileName = 'file';
        $uploadPath = "../../frontend/web/uploads" ;

        if (isset($_FILES[$fileName])) {
            $file = \yii\web\UploadedFile::getInstanceByName($fileName);

            //Print file data
            //print_r($file);
            /*
            moataz.png

            //create new table => media
            $file->name = rand(11111111,99999999).time().rand(111111,999999); 
            $model->fileExtension = $file->extension;
            $model->fileitle = $file->name;
            $model->section_id = $id;

            */
            
            if ($file->saveAs($uploadPath . '/' . $file->name)) {
                //Now save file data to database
                //$file->name = rand(11111111,99999999).time().rand(111111,999999); 
                //Yii::$app->db->createCommand()->insert('media', ['filetitle' => $file->name,'fileExtension' => $file->extension])->execute();



                echo \yii\helpers\Json::encode($file);
            }else {
                echo "No!";
            }
        }

        return false;
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
