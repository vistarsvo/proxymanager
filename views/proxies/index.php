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

use vistarsvo\proxymanager\assets\MainAsset;
use yii\helpers\Html;
use yii\grid\GridView;

MainAsset::register($this);
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proxy List';
$this->params['breadcrumbs'][] = $this->title;

yii\bootstrap\Modal::begin([
    'header' => '<span class="title">...</span>',
    'footer' => '<div class="footer">...</div>',
    'id'=>'modalWindow',
    'class' =>'modal',
    'size' => 'modal-lg',
]);
echo "<div class='modalContent'>...</div>";
yii\bootstrap\Modal::end();

?>
<div class="proxy-list-index">


    <p>
        <?= Html::a('Add new Proxy', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Drop bad Proxy', ['drop-bad'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Check all on page', 'javascript:CheckAll()', ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            'id' => [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function($data) {
                    return '<div class="proxyId">' . $data->id . '</div>';
                }
            ],
            'ip',
            'port',
            'type',
            'anonymous',
            'country',
            'login',
            'password',
            'status' => [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($data) {
                    return '<div id="proxy_' . $data->id . '">' . $data->status . '</div>';
                }
            ],

            'created_at:datetime',
            'updated_at:datetime',

            //<i class="fa fa-fw fa-globe"></i>

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {check}',
                'buttons' => [
                    'check' => function ($url, $model) {
                        return Html::a(
                            '<span class="fa fa-globe"></span>',
                            $url, [
                            'title' => "Check",
                            'class' => 'for-ajax',
                            'data-container' => '.modalContent',
                            'data-modal' => '#modalWindow',
                            'data-modalheader' => 'Proxy Check'
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>


