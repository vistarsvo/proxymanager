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


use vistarsvo\proxymanager\models\Proxy;

class SaveProxyArrayToDb
{
    private $_proxyArray;

    public function __construct(array $proxyArray)
    {
        $this->_proxyArray = $proxyArray;
    }

    public function save()
    {
        foreach ($this->_proxyArray as $proxy) {
            /** @var $proxyModel Proxy */
            $proxyModel = Proxy::find()->where(['ip' => $proxy['ip'], 'port' => $proxy['port']])->one();

            if (!$proxyModel) {
                $proxyModel = new Proxy();
                $proxyModel->created_at = time();
                $proxyModel->updated_at = 0;
            } else {
                $proxyModel->updated_at = time();
            }

            $proxyModel->ip = $proxy['ip'];
            $proxyModel->port = $proxy['port'];
            $proxyModel->country = $proxy['country'];
            $proxyModel->anonymous = $proxy['anonymous'];
            $proxyModel->type = $proxy['type'];
            $proxyModel->status = 1;

            if ($proxyModel->save(true)) {

            } else {

            }
        }
    }
}