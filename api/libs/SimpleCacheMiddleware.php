<?php

/////////////////////////////////////////////////////////////////
namespace SlimMidllewares;
require __DIR__."/vendor/autoload.php";

class SimpleCacheMiddleware extends \Slim\Middleware
{

    /////////////////////////////////////////////////////////////////
    protected $cacheFolder = "./";
    protected $cachedResources = array();
    
    /////////////////////////////////////////////////////////////////
    public function __construct($cacheFolder, $cachedResources) 
    {
        $this->cacheFolder = $cacheFolder."/";
        $this->cachedResources = $cachedResources;
    }

    /////////////////////////////////////////////////////////////////
    public function call()
    {
        $key = $this->app->request()->getResourceUri();
        $cacheExpiry = $this->isCached($key, $this->app->request->getMethod());
        if($cacheExpiry > 0) {
            $cache = new \Gilbitron\Util\SimpleCache();
            $cache->cache_path = $this->cacheFolder;   
            $rsp = $this->app->response();

            $cacheResults = $rsp->body(unserialize($cache->get_cache($key)));
            if($cacheResults !== false) 
            {
                $rsp->body($cacheResults);
                return;
            }

            $this->next->call();

            if ($rsp->status() == 200) 
            {
                $cache->set_cache($key, serialize($rsp->getBody()));
            }
        }
        else 
        {
            $this->next->call();
        }
    }

    /////////////////////////////////////////////////////////////////
    private function isCached($uri, $method) {
        foreach ($this->cachedResources as $cachedResourceKey => $cachedResourceValue)
        {
            $methodResource = "GET";
            $cachedResourceExpiry = $cachedResourceValue;
            if(is_array($cachedResourceValue)) {
                $methodResource = $cachedResourceValue[1];
                $cachedResourceExpiry = $cachedResourceValue[0];
            }
            if ($methodResource == $method && strpos($uri, $cachedResourceKey) !== FALSE)
            {
                return $cachedResourceExpiry;
            }
        }
        return -1;
    }
}

?>