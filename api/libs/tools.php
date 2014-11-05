<?php

/////////////////////////////////////////////////////////////
require __DIR__."/vendor/autoload.php";

/////////////////////////////////////////////////////////////
function getAPIURL()
{
    return getBaseUrl()."api";
}

/////////////////////////////////////////////////////////////
function getBaseUrl() {
    $absPath = str_replace("\\", "/", dirname(__FILE__)) . "/";
    $tempPath1 = explode("/", str_replace("\\", "/", dirname($_SERVER["SCRIPT_FILENAME"])));
    $tempPath2 = explode("/", substr($absPath, 0, -1));
    $tempPath3 = explode("/", str_replace("\\", "/", dirname($_SERVER["PHP_SELF"])));

    for ($i = count($tempPath2); $i < count($tempPath1); $i++) {
        array_pop ($tempPath3);
    }

    $urladdr = $_SERVER["HTTP_HOST"] . implode("/", $tempPath3);
    $protocol = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off" || $_SERVER["SERVER_PORT"] == 443) ? "https://" : "http://";

    if ($urladdr{strlen($urladdr) - 1}== "/")
        return $protocol.$urladdr;
    else
        return $protocol.$urladdr . "/";
}



?>