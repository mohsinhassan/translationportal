<?php

namespace backend\controllers;

use backend\models\Screenshot;
use backend\models\ScreenWindow;
use backend\models\Types;
use Yii;
use backend\models\SystemLabel;
use backend\models\SearchSystemLabel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * SystemLabelController implements the CRUD actions for SystemLabel model.
 */
class SystemLabelController extends Controller
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
     * Lists all SystemLabel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchSystemLabel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SystemLabel model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        //fetching data from screen_windows to get types string value
        $window = ScreenWindow::find()
            ->where(['window_id' => $model->window_id])
            ->one();

        //fetching data from types to get types string value
        $typeData = Types::find()
            ->where(['type_id' => $window['type_id']])
            ->one();

        //setting perticular type name for detail view
        $type = $typeData['type_name'];

        //fetching all screenshots images for view page
        $screenshotData = (new \yii\db\Query())
            ->select('*')
            ->from('screenshots')
            ->where(['window_id' => $id])
            ->all();

        return $this->render('view', [
            'model' => $model,
            'type' => $type,
            'screenshotData' => $screenshotData
        ]);
    }

    /**
     * Creates a new SystemLabel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SystemLabel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->label_id]);
        } else {
            $screenWindow = ArrayHelper::map(ScreenWindow::find()->all(), 'window_id', 'window_name');
            return $this->render('create', [
                'model' => $model,
                'screenWindow' => $screenWindow,
            ]);
        }
    }

    /**
     * Updates an existing SystemLabel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->label_id]);
        } else {
            $screenWindow = ArrayHelper::map(ScreenWindow::find()->all(), 'window_id', 'window_name');
            return $this->render('update', [
                'model' => $model,
                'screenWindow' => $screenWindow,
            ]);
        }
    }

    /**
     * Deletes an existing SystemLabel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /*
     * Function to redirect add translation page*/

    public function actionCreateTranslation($id)
    {
        return $this->redirect(['translation/createwithlabel','id' => $id]);
    }

    /**
     * Finds the SystemLabel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SystemLabel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SystemLabel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
