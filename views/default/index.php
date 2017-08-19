<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proxy manager';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proxy-default-index">
    <h1>Proxy Manager</h1>
    <p>
        <?=
        dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Список ресурсов', 'icon' => 'tasks', 'url' => ['/proxymanager/resources']],
                    ['label' => 'Список проксей', 'icon' => 'file-text', 'url' => ['/proxymanager/proxies']],
                ],
            ]
        ) ?>
    </p>
</div>
