<?php
/**
 * @author Eric Shi <wwolf5566@outlook.com>
 * @copyright Copyright (c) 2019
 * @license Please see LICENSE
 */

namespace EsTools\modules;

use phpQuery;

/**
 * Class EsPhpQuery
 *
 * @package EsTools\modules
 */
class EsPhpQuery extends EsModule
{
    /**
     * Now HTML contents
     *
     * @var string
     */
    private $html = '';

    /**
     * Get php query object
     *
     * @param $html
     * @return \phpQueryObject
     */
    public function getPhpQueryObject($html)
    {
        $this->html = $html;
        return phpQuery::newDocumentHTML($html);
    }

    /**
     * Convert Dom Element to PhpQueryObject
     *
     * @param $domElement
     * @return \phpQueryObject
     * @throws
     */
    public function convertToPhpQuery($domElement)
    {
        return phpQuery::pq($domElement);
    }

    /**
     * Get now HTML contents
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }
}
 