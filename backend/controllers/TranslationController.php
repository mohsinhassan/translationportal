<?php

namespace backend\controllers;

use backend\models\Language;
use backend\models\SystemLabel;
use backend\models\ScreenWindow;
use backend\models\Types;
use Yii;
use backend\models\Translation;
use backend\models\SearchTranslation;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * TranslationController implements the CRUD actions for Translation model.
 */
class TranslationController extends Controller
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
     * Lists all Translation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchTranslation();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Translation model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Translation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Translation();
        $model->created_by = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->translation_id]);
        } else {

            // getting system-label data
            //
            $systemLabel = SystemLabel::findOne($id);
            //$systemLabel;

            //fetching data from screen_windows to get types string value
            $window = ScreenWindow::find()
                ->where(['window_id' => $systemLabel->window_id])
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
                ->where(['window_id' => $systemLabel->window_id])
                ->all();
            //

            $labels = ArrayHelper::map(SystemLabel::find()->all(), 'label_id', 'label');
            $languages = ArrayHelper::map(Language::find()->all(), 'language_id', 'language_name');
            return $this->render('create', [
                'model' => $model,
                'labels' => $labels,
                'languages' => $languages,
                'systemLabel' => $systemLabel,
                'window' => $window,
                'type' => $type,
                'screenshotData' => $screenshotData,
            ]);
        }
    }

    /**
     * Creates a new Translation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreatewithlabel($id)
    {
        $model = new Translation();

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->translation_id]);
        }*/

        if ($model->load(Yii::$app->request->post())) {
            $model->label_id = intval($id);
            $model->language_id = 1;        // will fetch language id from the logged in user data
            $model->is_approved = 0;
            $model->created_by = Yii::$app->user->id;
            $model->save();
            \Yii::$app->getSession()->setFlash('success', 'Translation added successfully.<a href="../translation/index">Goto Translation List</a>');
            return $this->redirect(['system-label/index', 'id' => $model->translation_id]);
        }
        else {

            // getting system-label data
            //
            $systemLabel = SystemLabel::findOne($id);
            //$systemLabel;

            //fetching data from screen_windows to get types string value
            $window = ScreenWindow::find()
                ->where(['window_id' => $systemLabel->window_id])
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
                ->where(['window_id' => $systemLabel->window_id])
                ->all();
            //

            $labels = ArrayHelper::map(SystemLabel::find()->all(), 'label_id', 'label');
            $languages = ArrayHelper::map(Language::find()->all(), 'language_id', 'language_name');
            return $this->render('createwithlabel', [
                'model' => $model,
                'labels' => $labels,
                'languages' => $languages,
                'systemLabel' => $systemLabel,
                'window' => $window,
                'type' => $type,
                'screenshotData' => $screenshotData,
            ]);
        }
    }


    /**
     * Updates an existing Translation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->translation_id]);
        } else {
            $labels = ArrayHelper::map(SystemLabel::find()->all(), 'label_id', 'label');
            $languages = ArrayHelper::map(Language::find()->all(), 'language_id', 'language_name');
            return $this->render('update', [
                'model' => $model,
                'labels' => $labels,
                'languages' => $languages,
            ]);
        }
    }

    /**
     * Deletes an existing Translation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Translation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Translation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Translation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
