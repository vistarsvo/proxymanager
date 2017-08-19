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

namespace vistarsvo\proxymanager\helpers;

use vistarsvo\proxymanager\helpers\clients\Yii2HttpClient;
use vistarsvo\proxymanager\models\Proxy;
use yii\db\ActiveRecord;
use yii\httpclient\Response;

class CheckRandomProxy
{
    private $_url;

    public function setUrl(string $url)
    {
        $this->_url = $url;
    }

    public function check()
    {
        /** @var $proxy Proxy */
        for ($x = 1; $x <= 100; $x++) {
            $proxy = Proxy::find()
                ->where(['<', 'updated_at', (time() - 3600)])
                ->orderBy('RAND()')
                ->limit(1)
                ->one();
            if (!$proxy) return;

            $dsn = 'tcp://';
            if (!empty($proxy['login']) && !empty($proxy['password'])) {
                $dsn .= $proxy['login'] . ':' . $proxy['password'] . '@';
            }
            $dsn .= $proxy['ip'] . ':' . $proxy['port'];
            echo $dsn . "\n";
            $client = new Yii2HttpClient();
            $client->setClientOption('proxy', $dsn);

            $content = $client->getContent($this->_url);
            /** @var  $clientResponse Response */
            $clientResponse = $client->getClientResponse();

            if (!$content) {
                if ($content === false) {
                    echo "HTTP CLIENT EXCEPTION \n";
                } else {
                    if (!empty($clientResponse)) {
                        $code = $clientResponse->getHeaders()->get('http-code');
                        $statusCode = $clientResponse->getStatusCode();
                    } else {
                        $code = 'NULL';
                        $statusCode = 'statusCode';
                    }
                    echo "ERROR {$code} -- {$statusCode} \n";
                }
                $proxy->status = 0;
            } else {
                $proxy->status = 1;
                $code = $clientResponse->getHeaders()->get('http-code');
                $statusCode = $clientResponse->getStatusCode();
                echo "OK {$code} -- {$statusCode} \n";
            }
            $proxy->updated_at = time();
            $proxy->save();
        }
    }

    public function checkPersonal()
    {
        /** @var $proxy Proxy */
        for ($x = 1; $x <= 100; $x++) {
            $proxy = Proxy::find()
                ->where(['<', 'updated_at', (time() - 6)])
                ->andWhere(['LIKE', 'anonymous', 'personal'])
                ->orderBy('RAND()')
                ->limit(1)
                ->one();
            if (!$proxy) return;

            /*$dsn = 'tcp://';
            if (!empty($proxy['login']) && !empty($proxy['password'])) {
                //$dsn .= $proxy['login'] . ':' . $proxy['password'] . '@';
            }
            $dsn .= $proxy['ip'] . ':' . $proxy['port'];
            echo $dsn . "\n";*/
            $client = new Yii2HttpClient();
            $client->setClientOption(CURLOPT_PROXY, $proxy['ip'] . ':' . $proxy['port']);
            if (!empty($proxy['login']) && !empty($proxy['password'])) {
                $client->setClientOption(CURLOPT_PROXYUSERPWD, $proxy['login'] . ':' . $proxy['password']);
            }
            $content = $client->getContent($this->_url);
            /** @var  $clientResponse Response */
            $clientResponse = $client->getClientResponse();

            if (!$content) {
                if ($content === false) {
                    echo "HTTP CLIENT EXCEPTION \n";
                } else {
                    if (!empty($clientResponse)) {
                        $code = $clientResponse->getHeaders()->get('http-code');
                        $statusCode = $clientResponse->getStatusCode();
                    } else {
                        $code = 'NULL';
                        $statusCode = 'statusCode';
                    }
                    echo "ERROR {$code} -- {$statusCode} \n";
                }
                $proxy->status = 0;
            } else {
                $proxy->status = 1;
                $code = $clientResponse->getHeaders()->get('http-code');
                $statusCode = $clientResponse->getStatusCode();
                $content = substr($clientResponse->getContent(), 0, 100);
                echo "OK {$code} -- {$statusCode} \n";
                echo "OK {$content}  \n";
                echo "------------ \n";
            }
            $proxy->updated_at = time();
            $proxy->save();
        }
    }
}