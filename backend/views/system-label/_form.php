<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SystemLabel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="system-label-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php   echo $form->field($model, 'window_id')
        ->dropDownList(
            $screenWindow,           // Flat array ('id'=>'label')
            ['prompt'=>'Please Select Screen Window']    // options
        ); ?>

    <?= $form->field($model, 'access_key_android')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'access_key_ios')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

    <?php /*= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() */ ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
