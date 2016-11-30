<?php

session_start();

?>

<!DOCTYPE html>
<html lang="ru">
<html lang="ru">
<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Авторизация</title>

    <?php include 'modules/_header.txt'; ?>

</head>
<body>

<!-- Стартовый экран -->
<div id="cover">
    <div id="cover-caption">
        <div class="container">
            <div class="pull-right hidden-sm-down" id="start">
                <? if (isset($_SESSION['login'])) : ?>
                    <h1>Здравствуйте <span style="color: #ff0;"><?=$_SESSION['login']; ?></span></h1>
                    <br/>
                    <form class="text-xs-left" method="post" action="modules/authorization.php">
                        <a class="btn btn-success btn-lg" href="sale.php">Продолжить</a>
                        <button type="submit" name="logout" class="btn btn-danger btn-lg float-xs-right">Выйти</button>
                    </form>
                <? else : ?>

                <h1>Авторизуйтесь пожалуйста</h1>
                <br />
                <form method="post" action="modules/authorization.php">
                    <div class="form-group row">
                        <label for="login" class="col-xs-4 col-form-label text-xs-right">Login:</label>
                        <div class="col-xs-8">
                            <input
                                class="form-control form-control-lg"
                                type="text"
                                name="login"
                                id="login"
                                placeholder="Login"
                                required
                            >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-xs-4 col-form-label text-xs-right">Password:</label>
                        <div class="col-xs-8">
                            <input
                                class="form-control form-control-lg"
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Password"
                                required
                            >
                        </div>
                    </div>

                    <? if (isset($_GET['error'])) : ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <p class="message" id="error"><?= $_SESSION['error']; ?></p>
<!--                                <p id="error">--><?//= $_SESSION['login']; ?><!--</p>-->
<!--                                <p id="error">--><?//= $_SESSION['password-1']; ?><!--</p>-->
<!--                                <p id="error">--><?//= $_SESSION['password-2']; ?><!--</p>-->
                            </div>
                        </div>
                    <? endif; ?>

                    <? if (isset($_GET['authorization'])) : ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <p class="message" id="authorization">Авторизуйтесь для доступа к <span style="color: #ff0;"><?= $_SESSION['page']; ?></span></p>
                            </div>
                        </div>
                    <? endif; ?>
                    
                    <button type="submit" name="enter" class="btn btn-success btn-lg float-xs-right">Авторизаваться</button>
                </form>

                <? endif; ?>

        </div>
    </div>
</div>
<!-- Конец Стартового экрана -->



<!-- Сначала jQuery, затем Bootstrap JS. -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>

</body>
</html>