<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Screenshot */

$this->title = $model->screenshot_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Screenshots'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="screenshot-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->screenshot_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->screenshot_id], [
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
            'screenshot_id',
            [
                'attribute' => 'screenshot.window_id',
                'value' => ucfirst($model->window->window_name), // or use 'usertable.name'
            ],
            /*'image',*/
            [
                'attribute' => 'image picture',
                'format' => 'html',
                'value' => function ($data) {
                    return Html::img(Yii::getAlias('@image_path'). $data['image'],
                        ['width' => '200px']);
                },
            ],
            'created_at',
        ],
    ]) ?>

</div>
