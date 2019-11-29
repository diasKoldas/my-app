<?php


namespace MyRoute;


use MyRoute\Parser;

class Route
{
    const NOT_FOUND = 0;
    const FOUND = 1;
    const METHOD_NOT_ALLOWED = 2;

    protected static $httpMethod = null;
    protected static $routes = [];
    protected static $handler = [];

    public static function addRoute($httpMethod, $routePattern, $handler)
    {
        $routeRegex = Parser::getRegex($routePattern);

        self::$httpMethod = $httpMethod;
        self::$handler = $handler;
        self::$routes[$routeRegex] = [$httpMethod, $handler, 'template' => $routePattern];
    }

    public static function getRoutes()
    {
        return self::$routes;
    }

    public static function checkQuery($httpMethod, $query)
    {
        $routeInfo = [];

        foreach (self::getRoutes() as $regex => $route)
        {
            if (preg_match($regex, $query, $matches))
            {
                $routeInfo = $route;
            }
        }

        if (count($routeInfo) == 0)
        {
            $routeInfo['status'] = self::NOT_FOUND;
            return $routeInfo;
        }

        if ($routeInfo[0] !== $httpMethod)
        {
            $routeInfo['status'] = self::METHOD_NOT_ALLOWED;
            return $routeInfo;
        }

        $routeInfo['vars'] = Parser::getVars($routeInfo['template'], $query);
        $routeInfo['status'] = self::FOUND;

        return $routeInfo;
    }
}