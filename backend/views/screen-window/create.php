<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ScreenWindow */

$this->title = Yii::t('app', 'Create Screen Window');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Screen Windows'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="screen-window-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'types' => $types,
    ]) ?>

</div>
