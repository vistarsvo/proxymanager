<?php

namespace vistarsvo\proxymanager\models;

use Yii;

/**
 * This is the model class for table "proxy".
 *
 * @property integer $id
 * @property string $ip
 * @property integer $port
 * @property string $type
 * @property string $anonymous
 * @property string $country
 * @property string $login
 * @property string $password
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Proxy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proxy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'port', 'type', 'anonymous', 'country'], 'required'],
            [['port', 'status', 'created_at', 'updated_at'], 'integer'],
            [['ip'], 'string', 'max' => 16],
            [['type', 'anonymous', 'country'], 'string', 'max' => 16],
            [['login', 'password'], 'string', 'max' => 64],
            [['ip', 'port'], 'unique', 'targetAttribute' => ['ip', 'port'], 'message' => 'The combination of Прокси IP and Прокси Порт has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Прокси IP',
            'port' => 'Прокси Порт',
            'type' => 'Тип прокси HTTP, HTTPS, SOCKS',
            'anonymous' => 'Анонимность',
            'status' => 'Активность',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'country' => 'Страна',
        ];
    }
}