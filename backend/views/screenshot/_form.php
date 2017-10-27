<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Screenshot */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="screenshot-form">

    <?php
    $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'] // important
    ]); ?>

    <div class="form-group">
        <?php echo $form->field($model, 'window_id')
            ->dropDownList(
                $screenWindow,           // Flat array ('id'=>'label')
                ['prompt' => 'Please Select Screen Window']    // options
            ); ?>
    </div>
    <?php

    // logic for showing uploaded image for update page
    if ($model->isNewRecord) {

        echo $form->field($model, 'image[]')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*', 'multiple' => true],
            'pluginOptions' => ['allowedFileExtensions' => ['jpg', 'gif', 'png']
            ]]);
    } else {

        echo('<img src="' . Yii::getAlias('@image_path') . $model->image . '" height="150" />');

        echo $form->field($model, 'image')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*', 'multiple' => false],
            'pluginOptions' => ['allowedFileExtensions' => ['jpg', 'gif', 'png']
            ]]);
    }
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
