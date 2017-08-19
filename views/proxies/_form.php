<?php
/**
 * This file is part of the Vistar project.
 * This source code under MIT license
 *
 * Copyright (c) 2017 Vistar project <https://github.com/vistarsvo/>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \vistarsvo\proxymanager\models\Proxy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prx-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ip')->textInput() ?>

    <?= $form->field($model, 'port')->textInput() ?>

    <?= $form->field($model, 'login')->textInput() ?>

    <?= $form->field($model, 'password')->textInput() ?>

    <?= $form->field($model, 'country')->textInput() ?>

    <?= $form->field($model, 'anonymous')->dropDownList([
        'elite proxy' => 'elite proxy',
        'anonymous' => 'anonymous',
        'transparent' => 'transparent',
        'personal' => 'personal',
    ]) ?>

    <?= $form->field($model, 'type')->dropDownList([
        'HTTP' => 'HTTP',
        'HTTPS' => 'HTTPS',
        'SOCKS4' => 'SOCKS4',
        'SOCKS5' => 'SOCKS5',
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList([
        '0' => 'Disabled',
        '1' => 'Enabled'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
