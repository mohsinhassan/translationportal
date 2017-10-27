<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?><!--

    <?php echo $form->field($model, 'password_hash')->textInput() ?>

    <?php echo $form->field($model, 'password')->passwordInput(); //['maxlength' => true]?>

    --><?php //echo $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php /*= $form->field($model, 'language_id')->textInput()*/ ?>

    <?php   echo $form->field($model, 'language_id')
        ->dropDownList(
            $language,           // Flat array ('id'=>'label')
            ['prompt'=>'Please Select Language']    // options
        ); ?>

    <?php //= $form->field($model, 'status')->textInput() ?>
    <div class="form-group">
        <?php //echo Html::dropDownList('status', $model, ['0'=>'In-Active', '1'=>'Active']); ?>

        <?php   echo $form->field($model, 'status')
            ->dropDownList(
                ['1'=>'Active','0'=>'In-Active', ] ); ?>
    </div>
    <!--<div class="form-group">
        <?/*= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) */?>
    </div>-->
    <div class="form-group">
        <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
