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

class CheckProxy
{
    private $_url;
    private $_id;

    public function setUrl(string $url)
    {
        $this->_url = $url;
        return $this;
    }

    public function setId(int $id)
    {
        $this->_id = $id;
        return $this;
    }

    public function check()
    {
        $return = [];
        $proxy = Proxy::findOne(['id' => $this->_id]);
        if (!$proxy) {
            $return = ['result' => 'error', 'message' => 'Proxy not found'];
            return $return;
        }

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
                $return = ['result' => 'error', 'message' => 'HTTP CLIENT EXCEPTION'];
            } else {
                if (!empty($clientResponse)) {
                    $code = $clientResponse->getHeaders()->get('http-code');
                    $statusCode = $clientResponse->getStatusCode();
                } else {
                    $code = 'NULL';
                    $statusCode = 'statusCode';
                }
                $return = ['result' => 'error', 'message' => "ERROR {$code} -- {$statusCode}"];
            }
            $proxy->status = 0;
        } else {
            $proxy->status = 1;
            $code = $clientResponse->getHeaders()->get('http-code');
            $statusCode = $clientResponse->getStatusCode();
            //$content = substr($clientResponse->getContent(), 0, 100);
            $return = ['result' => 'success', 'message' => "OK {$code} -- {$statusCode}"];
        }
        $proxy->updated_at = time();
        $proxy->save();
        return $return;
    }

}