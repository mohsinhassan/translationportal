<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SystemLabel */

$this->title = Yii::t('app', 'Create System Label');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System Labels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-label-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'screenWindow' => $screenWindow,
    ]) ?>

</div>
