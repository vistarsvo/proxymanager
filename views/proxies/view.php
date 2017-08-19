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
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \vistarsvo\proxymanager\models\Proxy */

$this->title = $model->ip . ':' . $model->port;
$this->params['breadcrumbs'][] = ['label' => 'Proxy', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proxy-resource-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php
    if (isset($checkResult)) {
        echo '<pre>' . print_r($checkResult, 1) . '</pre>';
    }
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id' => [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function($data) {
                    return '<div class="proxyId">' . $data->id . '</div>';
                }
            ],
            'ip',
            'port',
            'anonymous',
            'country',
            'login',
            'password',
            'status',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>



</div>
