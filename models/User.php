<?php

namespace Models;

class User {
    private $_isLoggedIn, $_sessionName, $_cookieName;
    public static $currentLoggedInUser = null;
    public $id, $name, $email, $password, $admin, $remember_token;

    public function __construct ($user = null) {

        if($user)
        {
            $sql = "SELECT * FROM users WHERE id = " . $user;

            $dbh = \Core\DB::getInstance()->dbh();

            foreach( $dbh->query($sql)->fetch(\PDO::FETCH_ASSOC) as $key => $property )
            {
                $this->$key = $property;
            }

            $_SESSION['user'] = $this->id;
        }
    }


    public static function currentUser() {
        if(!isset(self::$currentLoggedInUser) && isset($_SESSION['user'])){
            $u = new User((int)$_SESSION['user']);
            self::$currentLoggedInUser = $u;
        }
        return self::$currentLoggedInUser;
    }

    public function remember()
    {
        $this->remember_token = \Core\HelperFunc::random_string(50);

        $sql = "UPDATE `users` SET `remember_token` = '" . $this->remember_token . "' WHERE `users`.`id` = " . $this->id;

        $dbh = \Core\DB::getInstance()->dbh();

        $dbh->query($sql);

        setCookie('remember', $this->remember_token, time() + 3600 * 24 * 90, '/');
    }

    public static function logout()
    {
        $user =  self::currentUser();
        if($user->remember_token)
        {
            $sql = "UPDATE `users` SET `remember_token` = NULL WHERE `users`.`id` = " .  $user->id;
            $dbh = \Core\DB::getInstance()->dbh();
            $dbh->query($sql);

            setcookie('remember', time() - 3600);
        }


        self::$currentLoggedInUser = NULL;

        session_unset();
    }

    public static function loginFromCookie()
    {
        $cookie = htmlspecialchars($_COOKIE['remember']);

        $sql = "SELECT * FROM `users` WHERE `remember_token`  =  ?";
        $dbh = \Core\DB::getInstance()->dbh();
        $sth = $dbh->prepare($sql);
        $sth->execute([$cookie]);

        $user = $sth->fetch(\PDO::FETCH_ASSOC);

        $user = new self($user['id']);

        return $user;
    }


    public function getAllUsers()
    {
        if($this->admin)
        {
            $sql = "SELECT * FROM `users` WHERE id !=" .$this->id;
            $dbh = \Core\DB::getInstance()->dbh();
            return $users = $dbh->query($sql);
        }
        return false;
    }


    public static function createNewUser($username, $email, $password)
    {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";

        $dbh = \Core\DB::getInstance()->dbh();

        $sth = $dbh->prepare($sql);
        return $sth->execute([$username, $email, $password]) ? true : false;
    }





}
