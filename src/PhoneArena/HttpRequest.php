<?php
namespace PhoneArena;
/**
 *
 */
class HttpRequest
{
    const URL_BASE = 'http://www.phonearena.com';

    var $useragent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; es-ES; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3";

    public function __construct() {
        if (!extension_loaded('curl')) {
            throw new PhoneArenaException('PHP extension CURL is not loaded.');
        }
    }

    function postRequest($url, $post)
    {
        $url = strpos($url, 'http') ? $url : self::URL_BASE . $url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    function getRequest($url, $referer = "http://google.es", $proxy=false)
    {
        $url = strpos($url, 'http') ? $url : self::URL_BASE . $url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->useragent);
        if ($proxy) {
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Seguir URL al momento de hacer curl
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4); // controla tiempo de espera al buscar.
        $buffer = curl_exec($ch);
        curl_close($ch);
        return $buffer;
    }

    function getLocation($url)
    {
        $url = strpos($url, 'http') ? $url : self::URL_BASE . $url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->useragent);
        curl_setopt($ch, CURLOPT_HEADER, true); //get header
        curl_setopt($ch, CURLOPT_NOBODY, true); //do not include response body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //do not show in browser the response
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //follow any redirects
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
        curl_exec($ch);
        $lnk = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL); //extract the url from the header response
        curl_close($ch);
        return $lnk;
    }


    function getStatus($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
        curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT,10);
        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $http_code;
    }
}