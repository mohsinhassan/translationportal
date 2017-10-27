<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ScreenWindow */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Screen Window',
]) . $model->window_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Screen Windows'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->window_id, 'url' => ['view', 'id' => $model->window_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="screen-window-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'screenShot' => $screenShot,
        'types' => $types,
        'screenshotRow' => $screenshotRow,
    ]) ?>

</div>
