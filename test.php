<?php

/////////////////////////////////////////////////////////////////
require_once __DIR__."/api/libs/tools.php";
require_once __DIR__."/api/libs/vendor/autoload.php";

/////////////////////////////////////////////////////////////////
// login (post)
//$request = Requests::post(getAPIURL()."/login", array("username"=>"test", "password"=>"test2"));
//var_dump($request->body);

// login (get)
//$request = Requests::get(getAPIURL()."/login/test/test2");
//var_dump($request->body);

// cached content
//$request = Requests::get(getAPIURL()."/reddits", array("token" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbiI6InRlc3QiLCJleHRyYSI6InllYWggISJ9.p8MhOsH-3ZP1xxAFFcRUI_oruqyVfb5qUV5b6iLKki"));
//var_dump($request->body);

// private content
$request = Requests::get(getAPIURL()."/private/lucas/mouilleron");
//$request = Requests::get(getAPIURL()."/private");
//$request = Requests::get(getAPIURL()."/private/lucas", array("token" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbiI6bnVsbCwiZXh0cmEiOiJ5ZWFoICEifQ.x5EQHtFEft8R8EEyLPkEz_MV2cNlJQdArscP7olwVHo"));
var_dump($request->body);

?>