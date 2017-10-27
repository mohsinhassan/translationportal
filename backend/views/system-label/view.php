<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SystemLabel */

$this->title = $model->label_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System Labels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-label-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->label_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->label_id], [
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
            'label_id',
            'window.window_name',
            /*'window.type.type_name',*/
            // getting types value for 0, 1

            [
                'label'=>'Type Name',
                'value'=>$type,
            ],
            'access_key_android',
            'access_key_ios',
            'label',
            'created_at',
            'updated_at',
        ],
    ]);
    foreach($screenshotData as $row)
    {
        echo ('<a href="../screenshot/view/'.$row['screenshot_id'].'" alt=" Update Screenshot"><img src="'. Yii::getAlias('@image_path').$row['image'] .'" height="150" alt=" view image "/></a>');

    }
    ?>
</div>
