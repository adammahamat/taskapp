<?php

namespace Core;

class Router
{
    public static function route($url)
    {
        // Controller
        $controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]) . 'Controller' : DEFAULT_CONTROLLER . 'Controller';
        $controller_name = str_replace('Controller', '', $controller);
        array_shift($url);

        // Action
        $action = (isset($url[0]) && $url[0] != '') ? $url[0] . 'Action' : 'indexAction';
        $action_name = (isset($url[0]) && $url[0] != "") ? $url[0] : 'index';
        array_shift($url);


        //Params
        $params = $url;

        $controller = 'controllers\\' . $controller;
        $dispatch = new $controller($controller_name, $action);


        if (method_exists($controller, $action)) {
            call_user_func_array([$dispatch, $action], $params);
        } else {
            die('That method does not exist in the controller "' . $controller_name . '"');
        }
    }
}