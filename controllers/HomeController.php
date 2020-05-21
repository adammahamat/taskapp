<?php
namespace Controllers;

use Core\Controller;
use \Models\User;

class HomeController extends Controller{

    public function indexAction()
    {


        $projects =  \Models\Task::show();

        $this->view->render('home', $projects);

    }

}