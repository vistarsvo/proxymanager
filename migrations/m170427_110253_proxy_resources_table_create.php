<?php

use yii\db\Migration;

class m170427_110253_proxy_resources_table_create extends Migration
{
    public $tempTableName = 'proxy_resources';
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT=\'Табличка с списком сайтов, от куда парсить прокси\'';

        $this->createTable($this->tempTableName, [
            'id' => $this->primaryKey(),
            'web' => $this->string(128)->notNull(),
            'parser' => $this->string(255)->notNull(),
            'took_time' => $this->integer()->notNull()->defaultValue(0),
            'proxy_collected' => $this->integer()->notNull()->defaultValue(0),
            'new_proxy_collected' => $this->smallInteger()->notNull()->defaultValue(0),
            'last_parse' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'refrash_time' => $this->integer()->notNull()->defaultValue(3600)
        ], $tableOptions);

        $this->addcommentOnColumn($this->tempTableName, 'web', 'Сайт с которого парсим');
        $this->addcommentOnColumn($this->tempTableName, 'parser', 'Параметры для вызова парсера');
        $this->addcommentOnColumn($this->tempTableName, 'took_time', 'Сколько времени занял парсинг');
        $this->addcommentOnColumn($this->tempTableName, 'proxy_collected', 'Сколько проксей');
        $this->addcommentOnColumn($this->tempTableName, 'new_proxy_collected', 'А сколько новых проксей');
        $this->addcommentOnColumn($this->tempTableName, 'last_parse', 'Когда парсили');
        $this->addcommentOnColumn($this->tempTableName, 'status', 'Активен или нет');
        $this->addcommentOnColumn($this->tempTableName, 'refrash_time', 'Через сколько времени можно сново парсить в сек');

        $this->insert($this->tempTableName, ['web' => 'http://hideme.ru', 'parser' => 'ParseHideMe']);
        $this->insert($this->tempTableName, ['web' => 'http://sslproxies.org', 'parser' => 'ParseSSLProxies']);
        $this->insert($this->tempTableName, ['web' => 'http://spys.ru', 'parser' => 'ParseSpys']);
        $this->insert($this->tempTableName, ['web' => 'http://proxydb.net', 'parser' => 'ParseProxydb']);
        $this->insert($this->tempTableName, ['web' => 'http://httptunnel.ge', 'parser' => 'ParseHttptunnel']);
        $this->insert($this->tempTableName, ['web' => 'http://proxy-list.org', 'parser' => 'ParseProxylistorg']);
        $this->insert($this->tempTableName, ['web' => 'http://proxylist.me/', 'parser' => 'ParseProxylistme']);
        $this->insert($this->tempTableName, ['web' => 'http://www.prime-speed.ru/proxy/', 'parser' => 'ParsePrimespeed']);
        $this->insert($this->tempTableName, ['web' => 'http://list.proxylistplus.com/SSL-Proxymanager', 'parser' => 'ParseProxylistplus']);
        $this->insert($this->tempTableName, ['web' => 'https://www.hide-my-ip.com/proxylist.shtml', 'parser' => 'ParseHidemyip']);
        $this->insert($this->tempTableName, ['web' => 'http://txt.proxyspy.net/proxy.txt', 'parser' => 'ParseProxyspy']);
        $this->insert($this->tempTableName, ['web' => 'https://best-proxies.ru/proxylist/free/', 'parser' => 'ParseBestproxies']);
        $this->insert($this->tempTableName, ['web' => 'http://www.samair.ru/ru/proxy/', 'parser' => 'ParseSamair']);
        $this->insert($this->tempTableName, ['web' => 'http://proxy.tekbreak.com', 'parser' => 'ParseTekbreak']);
        $this->insert($this->tempTableName, ['web' => 'http://proxy.am', 'parser' => 'ParseProxyam']);


        $this->createIndex(
            'idx-proxyres-last-parse-status',
            $this->tempTableName,
            ['last_parse', 'status']
        );

        $this->createIndex(
            'idx-proxyres-web',
            $this->tempTableName,
            ['web']
        );

        return true;
    }

    public function down()
    {
        $this->dropTable($this->tempTableName);

        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
