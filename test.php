<?php

/////////////////////////////////////////////////////////////////
require_once __DIR__."/api/libs/tools.php";
require_once __DIR__."/api/libs/vendor/autoload.php";

/////////////////////////////////////////////////////////////////
//$request = Requests::post(getAPIURL()."/login", array("username"=>"test", "password"=>"test2"));
//var_dump($request->body);

$request = Requests::get(getAPIURL()."/public/lucas");
var_dump($request->body);

?>