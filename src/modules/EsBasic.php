<?php
/**
 * @author Eric Shi <wwolf5566@outlook.com>
 * @copyright Copyright (c) 2019
 * @license Please see LICENSE
 */

namespace EsTools\modules;

/**
 * Class EsBasic
 *
 * @package EsTools\modules
 */
class EsBasic extends EsModule
{
    /**
     * ES encode
     *
     * @param $string
     * @return string
     */
    public function esEncode($string)
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
    public function esDecode($string)
    {
        $string = base64_decode(urldecode($string));

        return $string;
    }

    /**
     * Get IP address
     *
     * @return mixed
     */
    public function esGetClientAddress()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && strlen($_SERVER['HTTP_X_FORWARDED_FOR']) > 1) {
            $tmp_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $tmp_address = $_SERVER['REMOTE_ADDR'];
        }

        return $tmp_address;
    }

    /**
     * Start request use HTTP POST
     *
     * @param $url
     * @param $data
     * @return bool|string
     */
    public function esCurlPost($url, $data)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->config['UserAgents']['chrome']);
        @curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $tmp_info = curl_exec($curl);

        if (curl_errno($curl)) {
            $tmp_info = false;
        }

        curl_close($curl);

        return $tmp_info;
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

    /**
     * Pretty log
     *
     * @param $fPath
     * @param $fContents
     */
    public function esLogPretty($fPath, $fContents)
    {
        $line_cut = '----------------------------------------';
        $header = "\r\n\r\n" . $line_cut . "\r\n";
        $footer = "\r\n\r\n\r\n[" . date('Y-m-d H:i:s', time()) . ' ' . self::esGetClientAddress() . "]\r\n";
        $footer .= "[" . $_SERVER['HTTP_USER_AGENT'] . "]\r\n";
        $footer .= '[' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"] . "]\r\n";
        $footer .= $line_cut . "\r\n\r\n";
        $fContents = $header . $fContents . $footer;

        self::esLog($fPath, $fContents);
    }
}
 