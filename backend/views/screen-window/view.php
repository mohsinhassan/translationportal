<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ScreenWindow */

$this->title = $model->window_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Screen Windows'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="screen-window-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->window_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->window_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'window_id',
            'window_name',
            'types.type_name',
            'created_at',
        ],
    ]);

        foreach($screenshotRows as $row)
        {
            echo ('<a href="../screenshot/view/'.$row['screenshot_id'].'" alt=" Update Screenshot"><img src="'. Yii::getAlias('@image_path').$row['image'] .'" height="150" alt=" view image "/></a>');
            /*
            '<img src =../../uploads/'
            DetailView::widget([
                 'model' => $row,
                 'attributes' => [
                     'image',
                     'photo:image',
                 ],
             ]);*/
            /*[
                'attribute'=>'photo',
                'value'=>,
                'format' => ['image',['width'=>'100','height'=>'100']],
            ]*/
            //echo "<br />".$row['image'];
        }
    ?>

</div>
