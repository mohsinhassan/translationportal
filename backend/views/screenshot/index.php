<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use backend\models\ScreenWindow;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchScreenshot */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('app', 'Screenshots');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="screenshot-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Screenshot'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'screenshot_id',
            /*'screen_windows_id',*/
            [
                "class" => yii\grid\DataColumn::className(),
                "attribute" => "window_id",
                'filter' => ArrayHelper::map(ScreenWindow::find()->orderBy('window_name')->asArray()->all(), 'window_id', 'window_name'),
                "value" => function($model){
                    if ($rel = $model->getWindow()->one()) {
                        return yii\helpers\Html::a($rel->window_name,["/screen-window/view/", 'id' =>$rel->window_id],["data-pjax"=>0]);
                    } else {
                        return '';
                    }
                },
                "format" => "raw",
            ],

            /*'image',*/
            [
                'attribute' => 'screenshot.image',
                'format' => 'html',
                'value' => function($model) {
                    return "<img src='".Yii::getAlias('@image_path').$model->image."' width='150' >";
                         //$str; // "<img src='../../uploads/".$model->image."' width='150'>";
                        //return "<img src=../../uploads/".$model->image."  width=150 />" ; //Html::img('../../uploads/'. $data['image'],
    //                        ['width' => '70px']);
                    },
            ],
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
