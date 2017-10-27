<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Screenshot */

$this->title = Yii::t('app', 'Create Screenshot');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Screenshots'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="screenshot-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'screenWindow' => $screenWindow,
    ]) ?>

</div>
