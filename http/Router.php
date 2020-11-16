<?php

namespace Http;


use App\Controller\NotFoundController;
use App\Core\User;



abstract class Router
{              
    
    /**
     * @var Routes 
     */     
    private static array $routes;        

    public static function route($cleanedUri): void
    {
        self::$routes = self::loadRoutes(require "http/routes.php");
        foreach (self::$routes[$_SERVER['REQUEST_METHOD']] as $pattern => $params) {
            if (preg_match( $pattern, $cleanedUri, $matches )) {
                if (User::$logged || !$params['logged']) {                                    
                    $action = $params['action'];                    
                    // Controller hívása a kapott metódussal.
                    (new $params['controller']($matches))->$action();
                    return;
                }               
            }
        }
        (new NotFoundController())->index();
    }  
    
    /**    
     * @param array $source
     * @return array $route
     */
    protected static function loadRoutes(array $source)
    {   
        $output = [];     

        foreach($source as $httpMethod => $routes) {
            if (is_array($routes)) {
                foreach($routes as $url => $params) {
                    if (is_array($params)) {
                        $pattern = self::createPattern($url);                        
                        if (array_key_exists("controller",$params) &&
                            array_key_exists("action",$params) &&
                            array_key_exists("logged",$params)) {
                            $output[strtoupper($httpMethod)]["{$pattern}"] = [                    
                                "controller" => $params["controller"] ? 
                                                $params["controller"] : 
                                                "App\Controller\HomeController",
                                "action" => $params["action"] ? 
                                            $params["action"] : 
                                            "index",
                                "logged" => $params["logged"] ? 
                                            $params["logged"] : 
                                            false,
                            ];
                        }
                    }     
                }
            }                
        }
        return $output;
    }

    /**
     * @param string $url
     * @return string $pattern
     */
    protected static function createPattern(string $path): string
    {
        $pattern = "%^";
        $classes = [
            "?<controller>",
            "?<action>",
            "?<id>"
        ];
        if (0 < strlen($path) && $path[0] !== "/" || strlen($path) == 0)
            $path = "/".$path;
        $elements = explode("/", $path);
        unset($elements[0]);
        for($i=0; $i<count($elements) && $i < 3; $i++) {
            if ($elements[$i+1] != "")
                $pattern.= "/(".$classes[$i].$elements[$i+1].")";
            if ($i == count($elements) -1 && $pattern != "%/") 
                $pattern.="/?";            
        }
        return $pattern."$%";
    }
}