<?php
/**
 * @author Eric Shi <wwolf5566@outlook.com>
 * @copyright Copyright (c) ${YEAR}
 * @license Please see LICENSE
 */

namespace EsTools;

use EsTools\lib\EsBase;

/**
 * Class Es
 *
 * @package ES
 */
class Es extends EsBase
{
    /**
     * ES encode
     *
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
     *
     * @param $string
     * @return bool|string
     */
    static public function esDecode($string)
    {
        $string = base64_decode(urldecode($string));

        return $string;
    }

    /**
     * @TODO: HTTP POST
     */
    public function esCurlPost()
    {

    }

    /**
     * Start request use HTTP GET
     *
     * @param $url
     * @return bool|string
     */
    public function esCurlGet($url)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->config['UserAgents']['chrome']);
        @curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_HTTPGET, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $tmp_info = curl_exec($curl);

        if (curl_errno($curl)) {
            /**
             * @TODO: Error processor
             */
            // $error_msg = curl_error($curl);
            $tmp_info = false;
        }

        curl_close($curl);

        return $tmp_info;
    }

    /**
     * Write file
     *
     * @param $fPath
     * @param $fContents
     */
    public function esLog($fPath, $fContents)
    {
        $fh = @fopen($fPath, 'a');
        @fwrite($fh, $fContents);
        @fclose($fh);
    }
}
 