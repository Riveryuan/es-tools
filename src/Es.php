<?php
/**
 * This file is part of the EsTools package.
 *
 * (c) Eric Shi <wwolf5566@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsTools;

/**
 * Class Es
 * @package ES
 */
class Es
{

    /**
     * ES encode
     * @param $string
     * @return string
     */
    static public function esEncode($string)
    {
        $string = urlencode(base64_encode($string));

        return $string;
    }

    /**
     * ES decode
     * @param $string
     * @return bool|string
     */
    static public function esDecode($string)
    {
        $string = base64_decode(urldecode($string));

        return $string;
    }
}
 