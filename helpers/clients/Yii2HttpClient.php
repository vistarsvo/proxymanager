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
 */

namespace vistarsvo\proxymanager\helpers\clients;


use yii\base\ErrorException;
use yii\httpclient\Exception;
use yii\httpclient\Client;

/**
 * Class YiiHttpClient
 * @package vistarsvo\proxymanager\helpers\clients
 */
class Yii2HttpClient implements ClientInterface
{
    /** @var array http-client options */
    private $_clientOptions = [
        /*'followLocation' => true,
        'timeout' => 30,
        'userAgent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:53.0) Gecko/20100101 Firefox/53.0',
        'maxRedirects' => 10,
        'sslVerifyPeer' => false*/
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CONNECTTIMEOUT => 10, // connection timeout
        CURLOPT_TIMEOUT => 30, // data receiving timeout
        CURLOPT_USERAGENT => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:53.0) Gecko/20100101 Firefox/53.0',
        CURLOPT_ACCEPT_ENCODING => 'gzip',
        CURLOPT_ENCODING => 'gzip',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false
    ];

    /** @var Client **/
    private $_client;

    private $_clientResponse;

    /**
     * YiiHttpClient constructor.
     * @param string $userAgent
     */
    public function __construct(string $userAgent = '')
    {
        if ($userAgent) $this->_clientOptions['userAgent'] = $userAgent;
        $this->_client = new Client([
            'transport' => 'yii\httpclient\CurlTransport'
        ]);
    }

    /**
     * Add or update options key-value
     * @param $optionName
     * @param $optionValue
     */
    public function setClientOption($optionName, $optionValue)
    {
        $this->_clientOptions[$optionName] = $optionValue;
    }

    /**
     * Get content and return in text format
     * @param string $url
     * @return string
     */
    public function getContent(string $url): string
    {
        try {
            $clientResponse = $this->_client->createRequest()
                ->setMethod('get')
                ->setUrl($url)
                ->setOptions($this->_clientOptions)
                ->setHeaders(['Accept-Language' => 'ru,ru-RU;q=0.8,en-US;q=0.5,en;q=0.3'])
                ->addHeaders(['Accept-Encoding' => 'gzip,deflate'])
                ->send();

            $this->_clientResponse = $clientResponse;

            if ($clientResponse->isOk) {
                $content = $clientResponse->getContent();

                /*
                if ($clientResponse->getHeaders()->has("content-encoding")) {
                    if ($clientResponse->getHeaders()->get("content-encoding") == 'gzip') {
                        $content = gzdecode($content);
                    }
                    if ($clientResponse->getHeaders()->get("content-encoding") == 'deflate') {
                        $content = gzdeflate($content);
                    }
                }
*/
                return $content;
            } else {
                return '';
            }
        } catch (Exception $exception) {
            echo $exception->getMessage() . "\n";
            return false;
        } catch (ErrorException $exception) {
            echo $exception->getMessage() . "\n";
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getClientResponse()
    {
        return $this->_clientResponse;
    }

    /**
     * Unset yii2 http client
     */
    public function __destruct()
    {
        unset($this->_client);
    }
}