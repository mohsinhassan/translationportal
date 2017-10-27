<?php

namespace backend\controllers;

use Yii;
use backend\models\Screenshot;
use backend\models\SearchScreenshot;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use backend\models\ScreenWindow;
use yii\helpers\ArrayHelper;


/**
 * ScreenshotController implements the CRUD actions for Screenshot model.
 */
class ScreenshotController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Screenshot models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchScreenshot();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Screenshot model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Screenshot model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->screenshot_id]);
        } */

//        if ($model->load(Yii::$app->request->post())) {
        $model = new Screenshot();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->attachment = UploadedFile::getInstance($model, 'image');

            if($model->attachment) {
                $path = '../../uploads/' . Yii::$app->security->generateRandomString() . '.' . $model->attachment->extension;
               /* $count = 0;
                {
                    while(file_exists($path)) {
                        $path = '../../uploads/' . $model->attachment->baseName . '_'.$count.'.' . $model->attachment->extension;
                        $count++;
                    }
                }*/
                $model->attachment->saveAs($path);
                $model->attachment =  $path;
            }

            $model->save();

            ////////////////////////////
            $request = Yii::$app->request;
            $window_id = $request->post('Screenshot');

            //////////////////////////////////////////////////
            $numUploadedfiles = count($_FILES['Screenshot']['name']['tmp_image']);
            for($i = 0; $i < $numUploadedfiles; $i++)
            {
                $model = new Screenshot();
                $model->image = UploadedFile::getInstance($model, 'tmp_image');

                $tmp = explode('.', $_FILES['Screenshot']['name']['tmp_image'][$i]);
                $ext = end($tmp);

                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");

                $filesize = $_FILES['Screenshot']["size"]["tmp_image"][$i];
                $maxsize = 5 * 1024 * 1024;
                if($filesize > $maxsize) die("Error: File size is larger than the allowed limit(5MB).");

                $model->image = Yii::$app->security->generateRandomString().".{$ext}";

                if (move_uploaded_file($_FILES["Screenshot"]["tmp_name"]["tmp_image"][$i], "../uploads/" . $model->image)) {
                    $model->window_id = $window_id['window_id'];
                    $model->save(false);
                   // echo "<br/>The file ". basename($_FILES["Screenshot"]["name"]["tmp_image"][$i]). " has been uploaded.";
                } else {
                    echo "<br/>Sorry, there was an error uploading your file.";
                }

                /*$image= $_FILES['Screenshot']['name']['tmp_image'][$i];
                if($model->save()){
                    $image->saveAs($path);
                    // return $this->redirect(['index']);
                    return $this->redirect(['view', 'id' => $model->screenshot_id]);
                } else {
                    // error in saving model
                }*/
                // or do whatever
            }
            return $this->redirect(['index']);


            /*// get the uploaded file instance. for multiple file uploads
            // the following data will return an array
            $image[] = UploadedFile::getInstance($model, 'tmp_image');
            echo "<pre>"; print_r($image);exit;
            // store the source file name
            $model->image[] = $image->name;
            $tmp = explode('.', $model->image);
            $ext = end($tmp);

            //$ext = "jpg"; //end((explode(".", $image->name)));

            // generate a unique file name
            $model->image = Yii::$app->security->generateRandomString().".{$ext}";

            // the path to save file, you can set an uploadPath
            // in Yii::$app->params (as used in example below)
            //$path = Yii::$app->params['uploadPath'] . $model->avatar;
            $path = '../uploads/' . $model->image;

            if($model->save()){
                $image->saveAs($path);
               // return $this->redirect(['index']);
                return $this->redirect(['view', 'id' => $model->screenshot_id]);
            } else {
                // error in saving model
            }*/
        }else {
            $model = new Screenshot();
            $screenWindow = ArrayHelper::map(ScreenWindow::find()->all(), 'window_id', 'window_name');
            return $this->render('create', [
                'model' => $model,
                'screenWindow' => $screenWindow,
            ]);
        }
    }

    /**
     * Updates an existing Screenshot model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        /*$model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->screenshot_id]);
        }*/
        $request = Yii::$app->request;
        $window_id = $request->post('Screenshot');

        //////////////////////////////////////////////////
        $model = $this->findModel($id);
        $oldImage = $model->image;
        //echo $oldImage;exit;

        $screenWindow = ArrayHelper::map(ScreenWindow::find()->all(), 'window_id', 'window_name');
        if ($model->load(Yii::$app->request->post())) {



                $model->image = UploadedFile::getInstance($model, 'image');
               // echo "<pre>";print_r($model->image);exit;

                if(!empty($model->image)) {
                    $fileName = Yii::$app->security->generateRandomString() . '.' . $model->image->extension;
                    $path = "../uploads/".$fileName ;
                    /* $count = 0;
                     {
                         while(file_exists($path)) {
                             $path = '../../uploads/' . $model->image->baseName . '_'.$count.'.' . $model->image->extension;
                             $count++;
                         }
                     }*/

                    //unlink(Yii::getAlias('@root')."/uploads/".$oldImage);
                    //echo $oldImage;exit;
                    if (file_exists(dirname(dirname(__DIR__)) . "/backend/uploads/" . $oldImage)) {
                        @unlink(dirname(dirname(__DIR__)) . "/backend/uploads/" . $oldImage);
                    }
                    $model->image->saveAs($path);
                    $model->image =  $fileName;
                }
                else{
                    //echo "no";exit;
                    $model->image = $oldImage;
                }
            $model->save();


           // $numUploadedfiles = count($_FILES['Screenshot']['name']['tmp_image']);
           /* if($numUploadedfiles >0 )
            {
                unlink current picture
            }*/

            /*$model->image = UploadedFile::getInstance($model, 'tmp_image');

            for ($i = 0; $i < $numUploadedfiles; $i++) {
                $model = new Screenshot();
                $model->image = UploadedFile::getInstance($model, 'tmp_image');

                $tmp = explode('.', $_FILES['Screenshot']['name']['tmp_image'][$i]);
                $ext = end($tmp);

                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                if (!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");

                $filesize = $_FILES['Screenshot']["size"]["tmp_image"][$i];
                $maxsize = 5 * 1024 * 1024;
                if ($filesize > $maxsize) die("Error: File size is larger than the allowed limit(5MB).");

                $model->image = Yii::$app->security->generateRandomString() . ".{$ext}";

                if (move_uploaded_file($_FILES["Screenshot"]["tmp_name"]["tmp_image"][$i], "../uploads/" . $model->image)) {
                    $model->screen_windows_id = $screen_windows_id['screen_windows_id'];
                    $model->save(false);
                    // echo "<br/>The file ". basename($_FILES["Screenshot"]["name"]["tmp_image"][$i]). " has been uploaded.";
                } else {
                    echo "<br/>Sorry, there was an error uploading your file.";
                }

            /*$image= $_FILES['Screenshot']['name']['tmp_image'][$i];
            if($model->save()){
                $image->saveAs($path);
                // return $this->redirect(['index']);
                return $this->redirect(['view', 'id' => $model->screenshot_id]);
            } else {
                // error in saving model
            }* /
            // or do whatever
        }*/
        return $this->redirect(['index']);
    } else {
            return $this->render('update', [
                'model' => $model,
                'screenWindow' => $screenWindow,
            ]);
        }
    }

    /**
     * Deletes an existing Screenshot model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Screenshot model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Screenshot the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Screenshot::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
