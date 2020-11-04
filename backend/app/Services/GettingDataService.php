<?php

namespace App\Services;

use Illuminate\Http\Request;

class GettingDataService
{
    /**
     * @var string $url
     */
    public $url;

    /**
     * GettingDataService constructor.
     * @param string $url
     */
    function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @param $url
     * @return string|null
     */
    public function checkUrl($url)
    {
        $arUrl = parse_url($url);
        $ret = null;

        if (!array_key_exists("scheme", $arUrl)
            || !in_array($arUrl["scheme"], array("http", "https")))

            $arUrl["scheme"] = "https";

        if (array_key_exists("host", $arUrl) &&
            !empty($arUrl["host"]))

            $ret = sprintf("%s://%s%s", $arUrl["scheme"],
                $arUrl["host"], $arUrl["path"]);

        else if (preg_match("/^\w+\.[\w\.]+(\/.*)?$/", $arUrl["path"]))
            $ret = sprintf("%s://%s", $arUrl["scheme"], $arUrl["path"]);

        if ($ret && !empty($ret["query"]))
            $ret .= sprintf("?%s", $arUrl["query"]);
        return $ret;
    }

    /**
     * @param $url
     * @return string
     */
    function getPageFavicon($url)
    {
        $url = str_replace("http://", '', $url);
        return "http://www.google.com/s2/favicons?domain=" . $url;
    }

    /**
     * @param $url
     * @return mixed|null
     */
    function getPageTitle($url)
    {
        $page = file_get_contents($url);
        if (!$page) return null;
        $matches = array();
        if (preg_match('/<title>(.*?)<\/title>/', $page, $matches)) {
            return $matches[1];
        } else {
            return null;
        }
    }

    /**
     * @param $url
     * @return mixed
     */
    public function getMetaKeywords($url)
    {
        $tags = get_meta_tags($url);
        if (array_key_exists('keywords', $tags)) {
            if ($tags['keywords'] == '') {
                return 'Keywords are empty';
            }
            return $tags['keywords'];
        } else {
            return 'No Keywords';
        }
    }

    public function getMetaDescription($url)
    {
        $tags = get_meta_tags($url);
        if (array_key_exists('description', $tags)) {
            if (empty($tags['description'])) {
                return 'Description is empty';
            }
            return $tags['description'];
        } else {
            return 'No Description';
        }
    }
}
