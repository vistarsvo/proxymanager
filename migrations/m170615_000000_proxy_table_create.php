<?php

use yii\db\Migration;

class m170615_000000_proxy_table_create extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('proxy', [
            'id' => $this->primaryKey(),
            'ip' => $this->string(16)->notNull(),
            'port' => $this->integer()->notNull(),
            'type' => $this->string(16)->notNull(),
            'anonymous' => $this->string(16)->notNull(),
            'country' => $this->string(2)->notNull(),
            'login' => $this->string(64),
            'password' => $this->string(64),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->notNull()->defaultValue(0)
        ], $tableOptions);

        $this->addcommentOnColumn('proxy', 'ip', 'Прокси IP');
        $this->addcommentOnColumn('proxy', 'port', 'Прокси Порт');
        $this->addcommentOnColumn('proxy', 'type', 'Тип прокси HTTP, HTTPS, SOCKS');
        $this->addcommentOnColumn('proxy', 'anonymous', 'Анонимность');
        $this->addcommentOnColumn('proxy', 'status', 'Активность');
        $this->addcommentOnColumn('proxy', 'country', 'Страна');

        $this->createIndex(
            'idx-proxy-ip-port',
            'proxy',
            ['ip', 'port'],
            true
        );

        $this->createIndex(
            'idx-status-country',
            'proxy',
            ['status', 'country']
        );

        $this->createIndex(
            'idx-status-type',
            'proxy',
            ['status', 'type']
        );

        $this->createIndex(
            'idx-status-anonymous',
            'proxy',
            ['status', 'anonymous']
        );

        return true;
    }

    public function down()
    {
        $this->dropTable('proxy');
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
