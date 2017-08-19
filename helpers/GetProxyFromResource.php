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

namespace vistarsvo\proxymanager\helpers;

/**
 * Class GetProxyFromResource
 * @package vistarsvo\proxymanager\helpers
 */
class GetProxyFromResource
{
    private $_classNameParsers = 'vistarsvo\proxymanager\helpers\parsers\\';
    private $_proxies = [];

    /**
     * GetProxyFromResource constructor.
     * @param string $className
     * @param string $clientType
     */
    public function __construct(string $className, string $clientType = 'http')
    {
        if ($clientType == 'http') {
            $clientName = 'vistarsvo\proxymanager\helpers\clients\Yii2HttpClient';
        } else {
            $clientName = 'vistarsvo\proxymanager\helpers\clients\PhantomJSClient';
        }
        try {
            $client = \Yii::createObject($clientName);
            $this->_classNameParsers .= $className;

            $parser = \Yii::createObject($this->_classNameParsers, [$client]);
            $this->_proxies = $parser->getList();
        } catch (\ReflectionException $exception) {

        }
    }

    /**
     * @return mixed
     */
    public function getRandomOne()
    {
        shuffle($this->_proxies);
        return next($this->_proxies);
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->_proxies;
    }
}