<?php

/////////////////////////////////////////////////////////////////
namespace SlimMidllewares;
require __DIR__."/vendor/autoload.php";

class JWTAuthenticationMiddleware extends \Slim\Middleware
{

    /////////////////////////////////////////////////////////////////
    protected $JWTSignature;
    protected $protectedResources = array();

    /////////////////////////////////////////////////////////////////
    public function __construct($JWTSignature, $protectedResources) 
    {
        $this->JWTSignature = $JWTSignature;
        $this->protectedResources = $protectedResources;
    }

    /////////////////////////////////////////////////////////////////
    public function call()
    {
        $app = $this->app;

        if($this->isProtected($app->request->getPathInfo())) 
        {
            try 
            {
                global $token;
                $token = $this->getToken($app->environment);
                global $tokenDecoded;
                $tokenDecoded = \JWT::decode($token, $this->JWTSignature);
                $this->next->call();
            } 
            catch(\Exception $e) 
            {
                $app->response->body("Forbidden");
                $app->response->setStatus("403");
            }        
        }
        else 
        {
            $this->next->call();
        }
    }

    /////////////////////////////////////////////////////////////////
    public function login($username, $password) {

    //TODO AUTHENTICATE AGAINST DB OR WHATEVER

        $data = array(
            "login" => $username,
            "extra" => "yeah !"
            );
        return \JWT::encode($data, $this->JWTSignature);
    }

    /////////////////////////////////////////////////////////////////
    protected function isProtected($pathInfo) {
        foreach ($this->protectedResources as $protectedResource) 
        {
            $protectedResource = "@^/".$protectedResource."$@";
            if (preg_match($protectedResource, $pathInfo) == 1) 
            {
                return true;
            }
        }
        return false;
    }

    /////////////////////////////////////////////////////////////////
    protected function getToken($env) 
    {
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
        return $token;
    }
}

?>