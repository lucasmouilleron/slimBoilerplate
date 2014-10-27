<?php

/////////////////////////////////////////////////////////////////
require_once __DIR__."/libs/vendor/autoload.php";
require_once __DIR__."/libs/JWTAuthenticationMiddleware.php";
require_once __DIR__."/libs/SimpleCacheMiddleware.php";
require_once __DIR__."/libs/tools.php";

/////////////////////////////////////////////////////////////////
define("JWT_PRIVATE_KEY","i love kate");
define("CACHE_PATH", "./cache");
define("DEBUG", true);
define("REDDIT_API_URL","http://api.reddit.com/hot");

/////////////////////////////////////////////////////////////////
$app = new \Slim\Slim(array("debug" => DEBUG));

$app->response->headers->set("Content-Type", "application/json");

$JWTAuthenticationMiddleware = new \SlimMidllewares\JWTAuthenticationMiddleware(JWT_PRIVATE_KEY);
$app->add($JWTAuthenticationMiddleware);

$cachedRoutes = array("public" => 100);
$app->add(new \SlimMidllewares\SimpleCacheMiddleware(CACHE_PATH, $cachedRoutes));

/////////////////////////////////////////////////////////////////
$app->error(function (\Exception $e) use ($app) {
    $app->halt(500, json_encode("Server error"));
});

/////////////////////////////////////////////////////////////////
$app->notFound(function () use ($app) {
    $app->halt(404, json_encode("Not found"));
});

/////////////////////////////////////////////////////////////////
$app->post("/login",  array($JWTAuthenticationMiddleware, "login"), function () use ($app) {
    global $token;
    echo json_encode(array("token"=>$token));
});

/////////////////////////////////////////////////////////////////
$app->get("/login/:username/:password",  array($JWTAuthenticationMiddleware, "login"), function ($username, $password) use ($app) {
    global $token;
    echo json_encode(array("token"=>$token));
});

/////////////////////////////////////////////////////////////////
$app->get("/reddits", function () use ($app) {
    $request = Requests::get(REDDIT_API_URL);
    echo json_encode(json_decode($request->body)->data->children);
});

/////////////////////////////////////////////////////////////////
$app->post("/post/:name", function ($name) use ($app) {
    echo json_encode($app->request->post());
});

/////////////////////////////////////////////////////////////////
$app->get("/private/:name", array($JWTAuthenticationMiddleware, "authenticate"), function ($name) {
    echo json_encode(array("body" => "Private hello ".$name));
});

/////////////////////////////////////////////////////////////////
$app->run();

?>