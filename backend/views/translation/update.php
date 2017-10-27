<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Translation */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Translation',
]) . $model->translation_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->translation_id, 'url' => ['view', 'id' => $model->translation_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="translation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'labels' => $labels,
        'languages' => $languages,
        'systemLabel' => $systemLabel,
        'window' => $window,
        'type' => $type,
        'screenshotData' => $screenshotData,
    ]) ?>

</div>
