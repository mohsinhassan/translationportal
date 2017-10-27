<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>
            <?php /*= Html::activeDropDownList($model, 'language_id',
                ArrayHelper::map(Language::find()->all(), 'language_id', 'language_name'))*/ ?>
            <div class="form-group">
            <?/*= Html::activeDropDownList($model, 'id',$language)*/ ?>
             <?php   echo $form->field($model, 'language_id')
                ->dropDownList(
                    $language,           // Flat array ('id'=>'label')
                ['prompt'=>'Please Select Language']    // options
                ); ?>
            </div>
            <?php
            // get all product types from the corresponding table:
           /* $language = $languages::find()->orderBy('language_name')->asArray()->all();
            // create an array of pairs ('id', 'type-name'):
            $languageList = ArrayHelper::map($language, 'id', 'language_name');
            // finally create the drop-down list:
            $form->field($form, 'id')->dropDownList($languageList)*/
            ?>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
