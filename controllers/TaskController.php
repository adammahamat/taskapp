<?php


namespace Controllers;
use Core\Controller;
use Models\User;
use Models\Task;


class TaskController extends Controller {

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
    }

    public function indexAction()
    {
        $this->view->render('tasks/create_task');
    }

    public function createAction()
    {
        $validator = new \Core\Validator();
        $body = htmlspecialchars($_POST['body']);

        if(!isset($_SESSION['user']))
        {
            $username =  htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);


            //Validation
            $validator->validate($_POST, [
                'name' => [
                    'display' => 'Username',
                    'required' => true,
                    'no_specials' => true,
                    'unique' => 'users',
                    'min' => 3,
                    'max' => 16
                ],


                'email' => [
                    'display' => 'Email',
                    'required' => true,
                    'unique' => 'users',
                    'max' => 50,
                    'valid_email' => true
                ],

                'body' => [
                    'display' => 'Body',
                    'required' => true,
                    'min' => 3,
                    'max' => 250
                ]
            ]);
        } else {
            $username = User::currentUser()->name;
            $email = User::currentUser()->email;
            $validator->validate($_POST, [
                'body' => [
                    'display' => 'body',
                    'required' => true,
                    'min' => 3,
                    'max' => 250
                ]
            ]);
        }


        if ($validator->passed()) {
            Task::create($username, $email, $body);
            $_SESSION['task_created'] = true;
            $this->redirect('home');
        } else {
            $this->view->render('tasks/create_task', null, $validator->displayErrors());
        }

    }


    public function viewAction()
    {

        $page = $_GET['page'];
        $page = htmlspecialchars($page);

        if($page == 1 || !is_numeric($page)) {
            $this->redirect('home');
        }

        $projects =  Task::show($page);


        $this->view->render('tasks/view', $projects);

    }

    public function completeAction($params)
    {
        if (!User::currentUser()->admin) {
            $this->redirect('home');
        }

        $id = htmlspecialchars($_POST['id']);
        $task = new Task($params);
        $task->complete();


        $this->redirect('home');



    }


    public function changeOrderAction()
    {
        if(isset($_POST['order1']) && isset($_POST['order2']))
        {
            $order1 = htmlspecialchars($_POST['order1']);
            $order2 = htmlspecialchars($_POST['order2']);



            //validation by orderList
            $orderList = Task::$orderList;
            $validate = false;
            foreach($orderList as $key=>$order)
            {
                if($order1 == $order && ($order2 == "ASC" || $order2 == 'DESC'))
                {
                    $validate = true;
                    break;
                }

            }
            if ($validate){
                Task::changeOrder($order1,$order2);
            }





            return $this->back();

        }
    }



    public function redactAction($params)
    {
        $validator = new \Core\Validator();

        $body = htmlspecialchars($_POST['body']);
        $id = htmlspecialchars($params);

        if(!is_numeric($id)) return false;

        if(User::currentUser()->admin)
        {
            $validator->validate($_POST, [
                'body' => [
                    'display' => 'Body',
                    'required' => true,
                    'min' => 3,
                    'max' => 250
                ]
            ]);
        }


        if ($validator->passed())
        {
            $task = new Task($id);
            $task->redact($id, $body);
            return $this->back();
        } else{
            $url = explode('page='. PROOT, $_SERVER['HTTP_REFERER']);
            $_SESSION['errors'] = $validator->displayErrors();
            return $this->back();

        }

    }
}