<?php

namespace Models;


use MongoDB\Driver\Session;

class Task {
    public static $order = ['name', 'DESC'];
    public static $orderList = ['name','email','completed','redacted'];
    public $id,$name,$email,$body, $completed,$redacted;


    public function __construct($id)
    {

        $sql = "SELECT * FROM tasks WHERE id = ?";

        $dbh = \Core\DB::getInstance()->dbh();
        $sth = $dbh->prepare($sql);
        $sth->execute([$id]);
        foreach( $sth->fetch(\PDO::FETCH_ASSOC) as $key => $property )
        {
            $this->$key = $property;
        }

    }


    public function complete()
    {

        if ($this->completed)
        {

            $sql = "UPDATE tasks SET `completed` = NULL WHERE id=".$this->id;
            $this->completed = null;
        }else{
            $sql = "UPDATE tasks SET `completed` = 1 WHERE id=".$this->id;
            $this->completed = true;
        }


        $dbh = \Core\DB::getInstance()->dbh();
        $sth = $dbh->prepare($sql);
        $sth->execute();


    }

    //sets order for showing method
    public static function changeOrder($val1, $val2)
    {
        $_SESSION['order1'] = $val1;
        $_SESSION['order2'] = $val2;

    }


    public static function create($name, $email, $body)
    {
        $name = htmlspecialchars($name);
        $email = htmlspecialchars($email);
        $body = htmlspecialchars($body);


        $sql = "INSERT INTO tasks (name, email, body) VALUES (?, ?, ?)";

        $dbh = \Core\DB::getInstance()->dbh();

        $sth = $dbh->prepare($sql);
        return $sth->execute([$name, $email, $body]) ? true : false;
    }


    public static function show($count = 1)
    {
        if(!is_numeric($count)) return false;
        $count = $count * 3;

        $offset = $count - 3;


        if(isset($_SESSION['order1']) && isset($_SESSION['order2']))
        {
            $order1 = $_SESSION['order1'];
            $order2 = $_SESSION['order2'];
        }else{
            $order1 = self::$order[0];
            $order2 = self::$order[1];
        }

        if($offset > 0)
        {
            $sql = 'SELECT * from tasks  ORDER BY `' . $order1 . '` ' . $order2 . ' LIMIT 3 OFFSET ' .$offset;
        }else
        {
            $sql = 'SELECT * from tasks  ORDER BY `' .$order1. '` ' . $order2 . ' LIMIT '. $count;
        }


        $dbh = \Core\DB::getInstance()->dbh();

        $sth = $dbh->prepare($sql);
        $sth->execute();

        return $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

    }


    public static function countRows()
    {
        $sql = 'SELECT COUNT(*) from tasks';

        $dbh = \Core\DB::getInstance()->dbh();

        $sth = $dbh->prepare($sql);
        $sth->execute();

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        return $result[0]['COUNT(*)'];

    }


    public function redact($id, $body)
    {
        $sql = "UPDATE tasks SET `body` = ? WHERE id=".$this->id;


        $dbh = \Core\DB::getInstance()->dbh();
        $sth = $dbh->prepare($sql);
        $sth->execute([$body]);

        if(!$this->redacted)
        {
            $sql = "UPDATE tasks SET `redacted` = 1 WHERE id=".$this->id;


            $dbh = \Core\DB::getInstance()->dbh();
            $sth = $dbh->prepare($sql);
            $sth->execute();
        }



    }





}
