<?php

/////////////////////////////////////////////////////////////////
require_once __DIR__."/api/libs/tools.php";
require_once __DIR__."/api/libs/vendor/autoload.php";

$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbiI6InRlc3QiLCJleHRyYSI6InllYWggISJ9.p8MhOsH-3ZP1xxAFFcRUI_oruqyVfb5qUV5b6iLKkiI";

/////////////////////////////////////////////////////////////////
// login (post)
$request = Requests::post(getAPIURL()."/login", array(), array("username"=>"test", "password"=>"test2"));

// login (get)
//$request = Requests::get(getAPIURL()."/login/test/test2");

// cached content
//$request = Requests::get(getAPIURL()."/reddits", array("token" => $token));

// private content
//$request = Requests::get(getAPIURL()."/private/lucas/mouilleron");
//$request = Requests::get(getAPIURL()."/private");
//$request = Requests::get(getAPIURL()."/private/lucas", array("token" => $token));

var_dump($request->body);

?>