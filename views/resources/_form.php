<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \vistarsvo\proxymanager\models\ProxyResources */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prx-res-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'web')->textInput() ?>

    <?= $form->field($model, 'parser')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([
        '0' => 'Disabled',
        '1' => 'Enabled'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
