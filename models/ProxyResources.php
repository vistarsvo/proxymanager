<?php

namespace vistarsvo\proxymanager\models;

use Yii;

/**
 * This is the model class for table "proxy_resources".
 *
 * @property integer $id
 * @property string $web
 * @property string $parser
 * @property integer $took_time
 * @property integer $proxy_collected
 * @property integer $new_proxy_collected
 * @property integer $last_parse
 * @property integer $status
 * @property integer $refrash_time
 */
class ProxyResources extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proxy_resources';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['web', 'parser'], 'required'],
            [['took_time', 'proxy_collected', 'new_proxy_collected', 'last_parse', 'status', 'refrash_time'], 'integer'],
            [['web'], 'string', 'max' => 128],
            [['parser'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'web' => 'Ресурс',
            'parser' => 'Параметры вызова',
            'took_time' => 'Времени на парсинг',
            'proxy_collected' => 'Всего',
            'new_proxy_collected' => 'Новых проксей',
            'last_parse' => 'Последний парсинг',
            'status' => 'Активен',
            'refrash_time' => 'Парсим каждые сек',
        ];
    }
}
