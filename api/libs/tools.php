<?php

/////////////////////////////////////////////////////////////
require __DIR__."/vendor/autoload.php";

/////////////////////////////////////////////////////////////
function getAPIURL()
{
    $base_dir  = preg_replace("/libs$/", "", __DIR__);
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $doc_root  = preg_replace("!{$_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']);
    return $protocol.str_replace("//","/",$_SERVER["SERVER_NAME"]."/".rtrim(preg_replace("!^{$doc_root}!", '', $base_dir), "/"));
}

?>