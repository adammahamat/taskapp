<?php
use Core\Router;


//Alters directory separator if we are using windows
(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? define('DS', '/') : define('DS', DIRECTORY_SEPARATOR);
//Defining the root for the project. You have to change that after deployemnt to the actual site
define('ROOT', dirname(__FILE__));
//Load configuration
require_once ROOT.DS.'config'.DS.'config.php';

session_start();


//Autoload function
function autoload($className)
{
    $classAry = explode('\\', $className);
    $class = array_pop($classAry);
    $subPath = strtolower(implode(DS,$classAry));
    $path = ROOT . DS . $subPath . DS . $class . '.php';
    if(file_exists($path))
    {
        require_once($path);

    }
}
spl_autoload_register('autoload');




$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];


if(!isset($_SESSION['user']) && isset($_COOKIE['remember']))
{
    \Models\User::loginFromCookie();
}

Router::route($url);