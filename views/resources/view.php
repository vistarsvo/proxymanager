<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \vistarsvo\proxymanager\models\ProxyResources */

$this->title = $model->web;
$this->params['breadcrumbs'][] = ['label' => 'Proxy resource', 'url' => ['index']];
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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'web',
            'parser',
            'status',
            'proxy_collected',
            'new_proxy_collected'
        ],
    ]) ?>

</div>
