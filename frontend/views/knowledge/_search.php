<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\KnowledgeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="knowledge-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?= $form->field($model, 'globalSearch') ?>
    <div class="form-group">
        <?= Html::submitButton('Searchใส่คำค้นที่นี้', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Resetล้างข้อมูล', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
