<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Screenshot */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Screenshot',
]) . $model->screenshot_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Screenshots'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->screenshot_id, 'url' => ['view', 'id' => $model->screenshot_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="screenshot-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'screenWindow' => $screenWindow,
    ]) ?>

</div>
<script>

    document.onload(
        function(alert($(".class").val()));
    )
</script>
