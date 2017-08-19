<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \vistarsvo\proxymanager\models\ProxyResources */

$this->title = 'Update Proxy Resource: ' . $model->web;
$this->params['breadcrumbs'][] = ['label' => 'Proxy Resources', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->web, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="prx-res-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
