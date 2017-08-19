<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proxymanager Resources';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prx-res-index">


    <p>
        <?= Html::a('Add new Resource', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            'id',
            'web',
            'parser',
            'took_time',
            'proxy_collected',
            'new_proxy_collected',
            'last_parse',
            'status',
            'refrash_time',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
