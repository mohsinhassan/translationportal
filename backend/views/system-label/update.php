<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SystemLabel */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'System Label',
]) . $model->label_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System Labels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->label_id, 'url' => ['view', 'id' => $model->label_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="system-label-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'screenWindow' => $screenWindow,
    ]) ?>

</div>
