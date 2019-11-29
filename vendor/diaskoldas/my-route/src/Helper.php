<?php


namespace MyRoute;


class Helper
{
    public static function prepareQuery($query)
    {
        if (false !== $pos = strpos($query, '?')) {
            $query = substr($query, 0, $pos);
        }
        return rawurldecode($query);
    }

    public static function handlerCall($handler, $vars)
    {
        $controller = $handler[0];
        $action = $handler[1];
        $object = new $controller;
        $function = $action;
        return $object->$function($vars);
    }
}