<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>




<div class="d-flex bd-highlight mb-3">

    <div class="p-2 bd-highlight d-flex flex-column mb-5">

        <div style="padding-bottom: 20px;">
            <a class="btn btn-primary" href="<?= PROOT . 'task' ?>">Create new task</a>
        </div>
        <div>
            <?php
            $user = \Models\User::currentUser();
            if(!$user){?>
                <a class="btn btn-primary" href="<?=PROOT . 'register/login'?>">Login or Register</a>
            <?php }else{
                ?>
                <a class="btn btn-primary" href="<?=PROOT . 'register/logout'?>">logout</a>
            <?php }?>
        </div>

    </div>


    <form class ="ml-auto p-2 bd-highlight" action="<?= PROOT . 'task/changeOrder'?>" method="post">
        <select name="order1" class="form-control">
            <option value="name">Order by name</option>
            <option value="email">Order by email</option>
            <option value="completed">Order by field complete</option>
            <option value="redacted">Order by field redact</option>
        </select>

        <select name="order2" class="form-control">
            <option value="ASC">ascending</option>
            <option value="DESC">descending</option>

        </select>
        <button type="submit">Sort</button>
    </form>
</div>


<div>

    <?php

    $page = htmlspecialchars($_GET['page']);
    $prevPage = $page - 1;
    $nextPage = $page +1;

    foreach($tasks as $task)
    {

        ?>
        <div>

            <div class ="form-group d-flex flex-column border shadow p-3 mb-5">
                <div>
                    <label >Name:<?=$task['name']?></label>
                </div>
                <div>
                    <label>Email: <?=$task['email']?></label>
                </div>
                <?php if($task['redacted'])
                {
                    ?>
                    <div>
                        <label>Redacted</label>
                    </div>
                    <?php
                }
                ?>
                <?php if($task['completed'])
                {
                    ?>
                    <div>
                        <label>Completed</label>
                    </div>
                    <?php
                }
                ?>

                <?php if($user->admin)
                {
                    ?>

                        <div class="d-flex bd-highlight">
                            <form method="POST" action="<?= PROOT . 'task/redact/' . $task['id']?>" class="p-2 w-100 bd-highlight">
                                <input name="body" value="<?=$task['body']?>" class="form-control onChange="this.form.submit()" <?= $task['completed'] ? 'text-secondary' : '' ?> ">
                            </form>
                            <form method="POST" action="<?= PROOT . 'task/complete/' . $task['id']?>" class="p-2 flex-shrink-1 bd-highlight">
                                <input type="checkbox" class="bd-highligh"   onChange="this.form.submit()" <?= $task['completed'] ? 'checked': '' ?>>
                            </form>
                        </div>


                    </div>
                <?php
            }else{
                ?>
                <div>
                    <p class="form-control  <?= $task['completed'] ? 'text-secondary' : '' ?> "><?=$task['body']?></p>
                </div>

                <?php
            }
            ?>
        </div>


        <?php
    }

    ?>


    <?php

    if(isset($_SESSION['errors']))
    {
        echo $_SESSION['errors'];
        unset($_SESSION['errors']);
    }
    ?>
    <div>
        <a href="<?= PROOT . 'task/view/?page=' . $prevPage?>">Prev page </a>

        <?php
        $rows = \Models\Task::countRows();
        $lastPage = ceil($rows / 3);



        if($rows > ($page * 3))
        {
            ?>
            <a href="<?= PROOT . 'task/view/?page='.$nextPage?>">Next page </a>
            <a href="<?= PROOT . 'task/view/?page='.$lastPage?>">Last page</a>
            <?php
        }
        ?>
    </div>



</div>


</body>
</html>