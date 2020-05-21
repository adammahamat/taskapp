<?php
namespace Controllers;

use Core\Controller;
use Core\DB;
use Models\User;

class RegisterController extends Controller {

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
    }


    public function indexAction()
    {
        $this->view->render('register');
    }

    public function loginAction()
    {
        if(isset($_POST['name']) && isset($_POST['password']))
        {
            $username = htmlspecialchars($_POST['name']);
            $password = htmlspecialchars($_POST['password']);
        }
        //Validation
        $validator = new \Core\Validator();
        $validator->validate($_POST, [
            'name' => [
                'display' => 'Username',
                'required' => true,
                'min' => 3,
                'max' => 16
            ],

            'password' => [
                'display' => 'Password',
                'required' => true,
            ],
        ]);

        if($validator->passed())
        {
            $sql = "SELECT id, password FROM users WHERE name = ?" ;

            $dbh = DB::getInstance()->dbh();

            $sth = $dbh->prepare($sql);

            $sth->execute([$username]);

            $result = $sth->fetch(\PDO::FETCH_ASSOC);
            if(password_verify($password, ($result['password'])))
            {
                $user = new User($result['id']);

                if(isset($_POST['remember_me']) && $_POST['remember_me'] = 'on')
                {
                    $user->remember();
                }
                $this->redirect('home');
            }
            $validator->addError("Password or Username is incorrect");
        }
        $this->view->render('login', null, $validator->displayErrors());


    }

    public function logoutAction()
    {
        if(isset($_SESSION['user']))
        {
            User::logout();
            $this->redirect('home');
        }
    }


    public function registerAction()
    {
        $username = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        //Validation
        $validator = new \Core\Validator();
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
            'password' => [
                'display' => 'Password',
                'required' => true,
                'min' => 6
            ],
            'confirm_password' => [
                'display' => 'Confirm Password',
                'required' => true,
                'matches' => 'password'
            ]
        ]);

        if($validator->passed())
        {
            User::createNewUser($username, $email,$password);

            $this->redirect('home');
        }else {
            $this->view->render('register',null,$validator->displayErrors());
        }


    }
}