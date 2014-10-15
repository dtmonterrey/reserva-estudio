<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\indisponibilidade */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="indisponibilidade-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_estudio')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'inicio')->textInput() ?>

    <?= $form->field($model, 'fim')->textInput() ?>

    <?= $form->field($model, 'repetir')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
