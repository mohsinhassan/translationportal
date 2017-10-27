<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use backend\models\SystemLabel;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchTranslation */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Translations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="translation-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Translation'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'translation_id',
            [
                "class" => yii\grid\DataColumn::className(),
                "attribute" => "label_id",
                'filter' => ArrayHelper::map(SystemLabel::find()->orderBy('label')->asArray()->all(), 'label_id', 'label'),
                "value" => function($model){
                    if ($rel = $model->getLabel()->one()) {
                        return yii\helpers\Html::a($rel->label,["/system-label/view/", 'id' =>$rel->label_id],["data-pjax"=>0]);
                    } else {
                        return '';
                    }
                },
                "format" => "raw",
            ],
            'translation',
            /*'is_approved',*/
            [
                'attribute'=>'is_approved',
                'header'=>'Status',
                'filter' => ['1'=>'Approved', '0'=>'Not Approved'],
                'format'=>'raw',
                'value' => function($model, $key, $index)
                {
                    if($model->is_approved == '1')
                    {
                        return '<button class="btn green">Approved</button>';
                    }
                    else
                    {
                        return '<button class="btn red">Not Approved</button>';
                    }
                },
            ],
            /*'language.language_name',*/
            [
                "class" => yii\grid\DataColumn::className(),
                "attribute" => "language_id",
                'filter' => ArrayHelper::map(\backend\models\Language::find()->orderBy('language_id')->asArray()->all(), 'language_id', 'language_name'),
                "value" => function($model){
                    if ($rel = $model->getLanguage()->one()) {
                        return yii\helpers\Html::a($rel->language_name,["/language/view/", 'id' =>$rel->language_id],["data-pjax"=>0]);
                    } else {
                        return '';
                    }
                },
                "format" => "raw",
            ],
            [
                "class" => yii\grid\DataColumn::className(),
                "attribute" => "created_by",
                'filter' => ArrayHelper::map(\backend\models\User::find()->orderBy('id')->asArray()->all(), 'id', 'username'),
                "value" => function($model){
                    if ($rel = $model->getUser()->one()) {
                        return $rel->username;
                    } else {
                        return '';
                    }
                },
                "format" => "raw",
            ],
            /*'user.username',*/
            // 'created_by',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
