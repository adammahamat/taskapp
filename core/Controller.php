<?php
namespace Core;

use Core\View;
use Core\Router;

class Controller {
    protected $_controller, $_action;
    public $view;
    public $validator;

    public function __construct($controller, $action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->view = new View;
    }

    public static function redirect($location) {
        if(!headers_sent()) {
            header('Location: '.PROOT.$location);
            exit();
        } else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.PROOT.$location.'";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url="'.$location. '" />"';
            echo '</noscript>';exit;
        }
    }


    public static function back()
    {
        $url = explode('localhost'. PROOT, $_SERVER['HTTP_REFERER']);

        self::redirect($url[1]);
    }
}