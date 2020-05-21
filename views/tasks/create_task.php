<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

<div class="d-flex justify-content-center">
    <form class="form w-50" action="<?=PROOT?>Task/create/" method="post">
        <?php if(!isset($_SESSION['user']))
        {?>
        <div class="form-group">
            <label for="name">Username</label>
            <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>

        <?php }?>

        <div class="form-group">
            <label for="body">Body</label>
            <input type="textarea" name="body"  class="form-control">
        </div>
        <div>
            <input type="submit" name="create" value="Create task" class='btn btn-large btn-primary'>
        </div>
        <?php
        if($errors)
        {
            echo $errors;
        }
        ?>
    </form>
</div>




</body>
</html>