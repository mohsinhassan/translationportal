<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
//use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\models\Types;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchScreenWindow */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Screen Windows');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="screen-window-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Screen Window'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php //if (Yii::$app->session->hasFlash('success')): ?>
        <!--<div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type_id="button">×</button>
            <h4><i class="icon fa fa-check"></i>Saved!</h4>
            <?/*= Yii::$app->session->getFlash('success') */?>
        </div>-->
    <?php //endif;
    //
     ?>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'window_id',
            'window_name',
            [
                "class" => yii\grid\DataColumn::className(),
                "attribute" => "type_id",
                'filter' => ArrayHelper::map(Types::find()->orderBy('type_id')->asArray()->all(), 'type_id', 'type_name'),
                "value" => function($model){
                    if ($rel = $model->getTypes()->one()) {
                        return yii\helpers\Html::a($rel->type_name,["/types/".$rel->type_id, '' =>'' ,],["data-pjax"=>0]);
                    } else {
                        return '';
                    }
                },
                "format" => "raw",
            ],
            'created_at',
            [
                'attribute' => 'screenshot.image',
                'format' => 'html',
                'value' => function($model) {
                    $str = "";
                    foreach($model->screenshot as $screen)
                    {
                        $str .= "<a href='../screenshot/view/".$screen->screenshot_id."'><img src='".Yii::getAlias('@image_path').$screen->image."' width='150'></a><br />";
                        /*$str .= Html::img(Yii::getAlias('@image_path'). $screen->image,
                            ['width' => '70px']);*/

                        /*$str .= Html::img(Yii::getAlias('@image_path'). $screen->image,
                            ['width' => '70px', 'alt' => 'view image']);*/
                       /* return Html::img(Yii::getAlias('@image_path').$screen->image,
                            ['width' => '70px', 'alt' => 'view image']);*/

                        //Html::img('../../uploads/'. $screen->image); '../../uploads/'.
                        //ArrayHelper::map($model->screenshot, 'screenshot_id', 'image'),
                           //['width' => '70px']);
                    }
                    return $str;


                    /*return Html::img('../../uploads/'. ArrayHelper::map($model->screenshot, 'screenshot_id', 'image'),
                        ['width' => '70px']);*/

//                    return implode(', ', ArrayHelper::map($model->screenshot, 'screenshot_id', 'image'));

                    //return $model->screenshot->image;
                    //return Html::link('@' . $model->screenshot->image, '../../uploads/' . $model->screenshot->image);
                    //return $model->screenshot->image;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
