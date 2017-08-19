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


namespace vistarsvo\proxymanager\helpers\parsers;

use Symfony\Component\DomCrawler\Crawler;

class FreeProxyListNet extends ParserAbstract
{

    /** @var string  */
    private static $_clientType = "HTTP";

    /**
     * Returning HTTP/PhantomJS
     * @return string
     */
    public static function getClient() : string
    {
        return self::$_clientType;
    }

    public function getList(): array
    {
        $content = $this->httpClient()->getContent('https://free-proxy-list.net/');
        return $this->parseContent($content);
    }

    private function parseContent(string $html) : array
    {
        $proxyList = [];

        $mainPageCrawler = new Crawler();
        $mainPageCrawler->addContent($html, 'text\html');

        $trNodes = $mainPageCrawler->filter('table#proxylisttable tbody tr');

        foreach ($trNodes as $trNode) {
            $trCrawler = new Crawler($trNode);
            $tdNodes = $trCrawler->filter('td');
            $columnNumber = 1;
            $proxy = [];
            foreach ($tdNodes as $tdNode) {
                $tdCrawler = new Crawler($tdNode);
                $tdContent = trim($tdCrawler->html());
                switch ($columnNumber) {
                    case 1: $proxy['ip'] = $tdContent; break;
                    case 2: $proxy['port'] = $tdContent; break;
                    case 3: $proxy['country'] = $tdContent; break;
                    case 5: $proxy['anonymous'] = $tdContent; break;
                    case 7: $proxy['type'] = $tdContent == 'yes' ? 'HTTPS' : 'HTTP'; break;
                }
                $columnNumber++;
            }
            $proxyList[] = $proxy;
        }
        return $proxyList;
    }

}