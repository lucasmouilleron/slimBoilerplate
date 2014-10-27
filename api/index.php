<?php

/////////////////////////////////////////////////////////////////
// SETUP
/////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////
require_once __DIR__."/libs/vendor/autoload.php";
require_once __DIR__."/libs/JWTAuthenticationMiddleware.php";
require_once __DIR__."/libs/SimpleCacheMiddleware.php";
require_once __DIR__."/libs/tools.php";

/////////////////////////////////////////////////////////////////
define("JWT_PRIVATE_KEY","i love kate");
define("CACHE_PATH", "./cache");
define("DEBUG", false);
define("REDDIT_API_URL","http://api.reddit.com/hot");
$cachedRoutes = array("reddits" => 100);
$protectedRoutes = array("private/.+", "private");

/////////////////////////////////////////////////////////////////
// SLIM CONFIG AND MIDDLEWARES
/////////////////////////////////////////////////////////////////
$app = new \Slim\Slim(array("debug" => DEBUG));
$app->response->headers->set("Content-Type", "application/json");
$JWTAuthenticationMiddleware = new \SlimMidllewares\JWTAuthenticationMiddleware(JWT_PRIVATE_KEY, $protectedRoutes);
$app->add($JWTAuthenticationMiddleware);
$app->add(new \SlimMidllewares\SimpleCacheMiddleware(CACHE_PATH, $cachedRoutes));

/////////////////////////////////////////////////////////////////
// ERRORS
/////////////////////////////////////////////////////////////////
$app->error(function (\Exception $e) use ($app) {
    $app->halt(500, json_encode("Server error"));
});
$app->notFound(function () use ($app) {
    $app->halt(404, json_encode("Not found"));
});

/////////////////////////////////////////////////////////////////
// ROUTES
/////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////
$app->post("/login", function () use ($app, $JWTAuthenticationMiddleware) {
    $token = $JWTAuthenticationMiddleware->login($app->request->post("username"), $app->request->post("password"));
    echo json_encode(array("token"=>$token));
});

/////////////////////////////////////////////////////////////////
$app->get("/login/:username/:password", function ($username, $password) use ($app, $JWTAuthenticationMiddleware) {
    $token = $JWTAuthenticationMiddleware->login($username, $password);
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
$app->get("/private/:name", function ($name) {
    echo json_encode(array("body" => "Private hello ".$name));
});

/////////////////////////////////////////////////////////////////
$app->get("/private", function () {
    echo json_encode(array("body" => "Private"));
});

/////////////////////////////////////////////////////////////////
$app->run();

?>