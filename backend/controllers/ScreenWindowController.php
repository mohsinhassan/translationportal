<?php

namespace backend\controllers;

use backend\models\Types;
use Yii;
use backend\models\ScreenWindow;
use backend\models\SearchScreenWindow;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Screenshot;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;


/**
 * ScreenWindowController implements the CRUD actions for ScreenWindow model.
 */
class ScreenWindowController extends Controller
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
     * Lists all ScreenWindow models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchScreenWindow();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ScreenWindow model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        //fetching all screenshots images for view page
        $screenshotRows = (new \yii\db\Query())
            ->select('*')
            ->from('screenshots')
            ->where(['window_id' => $id])
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'screenshotRows' => $screenshotRows,
        ]);
    }

    /**
     * Creates a new ScreenWindow model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ScreenWindow();
        $types = ArrayHelper::map(Types::find()->all(), 'type_id', 'type_name');

        if ($model->load(Yii::$app->request->post())) {

            //making image empty for new image
            $model->image = "";

            //saving model value as posted
            if ($model->save()) {
                //getting images instance
                $images = UploadedFile::getInstances($model, 'image');

                //check if any image available
                if ($images) {

                    //loop for multiple images uploading
                    foreach ($images as $image) {

                        $filename = Yii::$app->security->generateRandomString() . '.' . $image->extension;
                        $path = '../uploads/' . $filename;

                        //checking uploaded file types
                        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                        if (!array_key_exists($image->extension, $allowed)) {

                            \Yii::$app->getSession()->setFlash('error', 'Please select a valid file format.');
                            return $this->redirect(['index']);
                        }

                        //processing image size limit validation for 5MB
                        $maxsize = 5 * 1024 * 1024;

                        if ($image->size > $maxsize) {
                            \Yii::$app->getSession()->setFlash('error', 'File size is larger than the allowed limit(5MB).');
                            return $this->redirect(['index']);
                        }

                        //setting all columns values for new screenshot model
                        $Screenshotmodel = new Screenshot();
                        $Screenshotmodel->image = $filename;
                        $Screenshotmodel->window_id = $model->window_id;

                        //saving uploaded image on server
                        $image->saveAs($path);
                        if ($Screenshotmodel->save()) {
                            \Yii::$app->getSession()->setFlash('success', 'Record(s) created successfully.');
                        } else {
                            \Yii::$app->getSession()->setFlash('error', 'Any one or more images can not uploaded, Please try again.');
                        }
                    }
                }
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'types' => $types,
            ]);
        }
    }

    /**
     * Updates an existing ScreenWindow model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //getting Types data
        $types = ArrayHelper::map(Types::find()->all(), 'type_id', 'type_name');

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            return $this->redirect(['view', 'id' => $model->window_id]);
        } else {
            $screenShot = Screenshot::find()->where(['window_id' => $id]);

            //fetching data for screenshot
            $screenshotRow = (new \yii\db\Query())
                ->select('*')
                ->from('screenshots')
                ->where(['window_id' => $model->window_id])
                ->all();

            return $this->render('update', [
                'model' => $model,
                'screenShot' => $screenShot,
                'types' => $types,
                'screenshotRow' => $screenshotRow,
            ]);
        }
    }

    /**
     * Deletes an existing ScreenWindow model.
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
     * Finds the ScreenWindow model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ScreenWindow the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ScreenWindow::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
