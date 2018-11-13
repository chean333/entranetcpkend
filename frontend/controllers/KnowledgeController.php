<?php

namespace frontend\controllers;

use Yii;
use app\models\Knowledge;
use app\models\KnowledgeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

/**
 * KnowledgeController implements the CRUD actions for Knowledge model.
 */
class KnowledgeController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Knowledge models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KnowledgeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Knowledge model.
     * @param integer $id
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
     * Creates a new Knowledge model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Knowledge();

        if($model->load(Yii::$app->request->post())){

            try{
                $model->files = UploadedFile::getInstances($model, 'files'); //upload หลายไฟล์ getInstances (เติม s)
                $model->files = $model->uploadFiles(); //method return ชื่อไฟล์ aaaa.aaa, bbbb.bbb, ...


                $model->save();//บันทึกข้อมูล

                Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                return $this->redirect(['index']);
            }catch(Exception $e){
                Yii::$app->session->setFlash('danger', 'มีข้อผิดพลาด');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Knowledge model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if($model->load(Yii::$app->request->post())){

            try{
                $model->files = UploadedFile::getInstances($model, 'files');//upload หลายไฟล์ getInstances (เติม s)
                $model->files = $model->uploadFiles();//method return ชื่อไฟล์ aaaa.aaa, bbbb.bbb, 


                $model->save();//บันทึกข้อมูล

                Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                return $this->redirect(['index']);
            }catch(Exception $e){
                Yii::$app->session->setFlash('danger', 'มีข้อผิดพลาด');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    public function actionDeleteFile($id, $file)
    {
        $model = $this->loadModel($id); //โหลด record ที่ต้องการมา
        try{
            $files = explode(',', $model->files); //เอาชื่อไฟล์มาแปลงเป็น array
            $files = array_diff($files, array($file)); //เอาชื่อไฟล์ที่ส่งมามาเอาออกจาก record
            unlink(Yii::getAlias('@webroot').'/'.$model->uploadFilesFolder.'/'.$file); //ลบไฟล์ออก
            $files = implode(',', $files); 
            $model->files = $files;//นำไฟล์ใหม่กลับเข้า attribute
            $model->save();//บันทึกข้อมูลใหม่
            Yii::$app->session->setFlash('success', 'ลบข้อมูลเรียบร้อยแล้ว');
            return $this->redirect(['view', 'id' => $model->id]);
        }catch(Exception $e){
            Yii::$app->session->setFlash('success', 'มีข้อผิดพลาด');
            return $this->redirect(['view', 'id' => $model->id]);
        }


    }

    /**
     * Deletes an existing Knowledge model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Knowledge model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Knowledge the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Knowledge::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function loadModel($id)
    {
        $model = Knowledge::findOne($id);
        if(!$model){
            throw new \Exception("Error Processing Request", 1);
        }
        return $model;
    }
}
