<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \vistarsvo\proxymanager\models\ProxyResources */

$this->title = 'Create New Proxy Resource';
$this->params['breadcrumbs'][] = ['label' => 'Proxy resources', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prx-res-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
