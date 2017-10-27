<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use backend\models\ScreenWindow;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchSystemLabel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'System Labels');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-label-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create System Label'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'label_id',
            'label',
            'access_key_android',
            'access_key_ios',
            [
                "class" => yii\grid\DataColumn::className(),
                "attribute" => "window_id",
                'filter' => ArrayHelper::map(ScreenWindow::find()->orderBy('window_name')->asArray()->all(), 'window_id', 'window_name'),
                "value" => function($model){
                    if ($rel = $model->getWindow()->one()) {
                        return yii\helpers\Html::a($rel->window_name,["/screen-window/view/", 'id' =>$rel->window_id],["data-pjax"=>0]);
                    } else {
                        return '-';
                    }
                },
                "format" => "raw",
            ],
            [
                "class" => yii\grid\DataColumn::className(),
                "attribute" => "window.type_id",
                "value" => function($model){
                    if($rel = $model->window->getTypes($model->window_id)->one()){
                        return $rel['type_name'];
                    }
                    else {
                        return "-";
                    }

                },
                "format" => "raw",
            ],
           /* ['class' => 'yii\grid\ActionColumn'],*/
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}{create-translation} ',
                'buttons' => [
                    'create-translation' => function ($url) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-plus-sign" style="padding-left:5px;"></span>',
                            $url,
                            [
                                'title' => 'Add Translation',
                                'data-pjax' => '0',
                            ]
                        );
                    },
                ],
            ],

           // ['class' => 'yii\grid\ActionColumn', 'template' => '{clients-visa/create}', 'buttons' => [ 'clients/create' => function ($url="index.php") { return Html::a( '<span class="glyphicon glyphicon-eye-open"> XX</span>', "index.php", [ 'title' => 'Add Client', 'data-pjax' => '0', ] ); }, ], ]
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
