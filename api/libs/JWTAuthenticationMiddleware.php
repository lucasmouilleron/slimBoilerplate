<?php

/////////////////////////////////////////////////////////////////
namespace SlimMidllewares;
require __DIR__."/vendor/autoload.php";
use \JWT;

class JWTAuthenticationMiddleware extends \Slim\Middleware
{

    /////////////////////////////////////////////////////////////////
    protected $JWTSignature;

    /////////////////////////////////////////////////////////////////
    public function __construct($JWTSignature) 
    {
        $this->JWTSignature = $JWTSignature;
    }

    /////////////////////////////////////////////////////////////////
    public function call()
    {
        $app = $this->app;
        $req = $app->request;
        $env = $app->environment;
        $method = $env->offsetGet("REQUEST_METHOD");
        $path = $env->offsetGet("PATH_INFO");
        if($method == "POST" && $this->startsWith($path,"/login"))
        {
            $this->doLogin($env->offsetGet("HTTP_X_USERNAME"), $env->offsetGet("HTTP_X_PASSWORD"));
        }

        //var_dump($this->app->request());
        $this->next->call();
    }

    /////////////////////////////////////////////////////////////////
    public function login(\Slim\Route $route) {
        $app = \Slim\Slim::getInstance();
        $getParams = $route->getParams();
        $postParams = $app->request->post();
        if(array_key_exists("username",$getParams) && array_key_exists("password",$getParams)) 
        {
            $this->doLogin($getParams["username"], $getParams["password"]);
        }
        else if(array_key_exists("username",$postParams) && array_key_exists("password",$postParams)) 
        {
            $this->doLogin($postParams["username"], $postParams["password"]);
        }
    }

    /////////////////////////////////////////////////////////////////
    public function authenticate(\Slim\Route $route)
    {
        $app = \Slim\Slim::getInstance();
        $env = $app->environment;
        $token = null;
        $extraParams = array();
        parse_str($env->offsetGet("QUERY_STRING"), $extraParams);
        if($env->offsetGet("HTTP_TOKEN") != null ) 
        {
            $token = $env->offsetGet("HTTP_TOKEN");
        }
        else if (array_key_exists("token",$extraParams)) {
            $token = $extraParams["token"];
        }
        if($token == null) $app->halt(403, "You shall not pass!");
        try 
        {
            $decoded = JWT::decode($token, $this->JWTSignature);
        } 
        catch(\Exception $e) 
        {
            $app->halt(403, "You shall not pass!");
        }
    }

    /////////////////////////////////////////////////////////////////
    protected function doLogin($login, $password) {

        //TODO AUTHENTICATE AGAINST DB OR WHATEVER

        $data = array(
            "login" => $login,
            "extra" => "yeah !"
            );
        global $token;
        $token = JWT::encode($data, $this->JWTSignature);
    }

    /////////////////////////////////////////////////////////////////
    private function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }
}

?>