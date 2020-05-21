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
    <form class="form w-50" action="<?=PROOT?>register/login" method="post">
        <h3 class='text-center'>Log In</h3>
        <div class="form-group">
            <label for="name">Username</label>
            <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="remember_me">Remember Me <input type='checkbox' id='remember_me' name="remember_me" value="on" ></label>
        </div>
        <div class="form-group">
            <input type="submit" name="login" value="Login" class='btn btn-large btn-primary'>
        </div>
        <div class="text-right">
            <a href="<?=PROOT?>register/" class="text-primary">Register</a>
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