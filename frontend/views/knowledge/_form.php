<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Knowledge */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="knowledge-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'knowledge')->textInput(['maxlength' => true]) ?>

    <?=$form->field($model, 'files[]')->fileInput(['multiple' => false])//ต้องมี [] ด้วยนะเพราะหลายไฟล์เป็น array และมี multiple ด้วย?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
