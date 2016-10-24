<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Склад</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css" integrity="sha384-MIwDKRSSImVFAZCVLtU0LMDdON6KVCrZHyVQQj6e8wIEJkW4tvwqXrbMIya1vriY" crossorigin="anonymous">

    <!-- Font Awesome CSS -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">

    <!-- Шрифт от Google - Roboto -->
    <!-- Мы используем только Roboto жирностью и начертанием:
         Light 300, Light 300 Italic,
         Normal 400, Normal 400,
         Medium 500, Medium 500 Italic -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,400italic,500italic,300,300italic' rel='stylesheet' type='text/css'>


    <!-- Styles -->
    <style>
        nav {
            background-color: #51bb07;
        }

        #products_tab {
            font-size: .6em;
        }

        .addform {
            background-color: #fafafa;
            border: 1px solid #cdcdcd;
            border-radius: 10px;
            padding: 15px 15px 0;
        }

        .editform {
            background-color: #fbffed;
            border: 1px solid #ebad5c;
            border-radius: 10px;
            padding: 15px 15px 0;
        }
    </style>
</head>


<body>
<?php
    $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
    $mysqli->query("SET NAMES 'utf8'");


if (isset($_GET['edit_id']))
{
    $edit_id = $_GET['edit_id'];
}
else if (isset($_POST['edit_id']))
{
    $edit_id = $_POST['edit_id'];
}
else
{
    $edit_id = -1;
}

// Строим БОЛЬШУЮ таблицу для добавления, удаления и редактирования данных
function printTable ($result_set) {
    $npp=1;
    while (($row = $result_set->fetch_assoc()) != false)
    {
        echo "<tr>";
        echo "<td>".$npp."</td>";
        echo "<td>".$row["product_name"]."</td>";
        echo "<td>";

        $mysqlg = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
        $mysqlg->query("SET NAMES 'utf8'");
        $unit_set = $mysqlg->query("SELECT * FROM `units`") or die();
        while (($urow = $unit_set->fetch_assoc()) != false)
        {
            if ($row['unit_id'] == $urow['unit_id'])
            {
                echo $urow['unit_name'];
            }
        }
        $mysqlg->close();
        
        echo "</td>";
        echo "<td>".$row["price_old"]."</td>";
        echo "<td>".$row["price_online"]."</td>";
        echo "<td>".$row["price_average"]."</td>";
        echo "<td>".$row["price_offset"]."</td>";
        echo "<td>".$row["protein"]."</td>";
        echo "<td>".$row["fat"]."</td>";
        echo "<td>".$row["carbohydrate"]."</td>";
        echo "<td>".$row["energy"]."</td>";
        echo "<td>".$row["store_min"]."</td>";
        echo "<td>".$row["store_online"]."</td>";
        echo "<td>".$row["store_max"]."</td>";
        echo "<td>
        <a name='del' href='product.php?del={$row["product_id"]}'>
        <i class='fa fa-times fa-2x' aria-hidden='true' style='color: red;'></i>
        </a>

        &nbsp;&nbsp;&nbsp;&nbsp;

        <a name='edit' href='product.php?editrow=editrow&edit_id={$row["product_id"]}'>
        <i class='fa fa-pencil-square-o fa-2x' aria-hidden='true' style='color: cornflowerblue;'></i>
        </a>
        </td>
        </tr>";
        $npp++;
    }
}

// Строим МАЛУЮ таблицу для просмотра
function showTable ($result_set) {
    $npp=1;
    while (($row = $result_set->fetch_assoc()) != false)
    {
        echo "<tr>";
        echo "<td>".$npp."</td>";
        echo "<td>".$row["product_name"]."</td>";
        echo "<td>".$row["price_old"]."</td>";
        echo "<td>".$row["price_online"]."</td>";
        echo "<td>".$row["price_offset"]."</td>";
        echo "<td>".$row["store_online"]."</td>";
        echo "<td>";

        $mysqlg = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
        $mysqlg->query("SET NAMES 'utf8'");
        $unit_set = $mysqlg->query("SELECT * FROM `units`") or die();
        while (($urow = $unit_set->fetch_assoc()) != false)
        {
            if ($row['unit_id'] == $urow['unit_id'])
            {
                echo $urow['unit_name'];
            }
        }
        $mysqlg->close();

        echo "</td>";
        echo "</tr>";
        $npp++;
    }
}

// Удаление данных из таблицы products
if(isset($_GET['del']))
{
    $del = (int) $_GET['del'];
    $query = "DELETE FROM `products` WHERE `product_id` = $del";
    /* Выполняем запрос. Если произойдет ошибка - вывести ее. */
    $mysqli->query($query) or die($query);
} 

// Добавление данных в таблицу products
if ($_POST['add'] == 'submit' || $_POST['editrow'] == 'editrow')
{
    $product_name = $_POST['product_name'];
    $unit_id = $_POST['unit_id'];
    $price_online = $_POST['price_online'];
    $protein = $_POST['protein'];
    $fat = $_POST['fat'];
    $carbohydrate = $_POST['carbohydrate'];
    $energy = $_POST['energy'];
    $store_min = $_POST['store_min'];
    $store_max = $_POST['store_max'];
    $store_online = $_POST['store_online'];


//    echo '$product_name = '.$product_name.'<br>';
//    echo '$unit_id = '.$unit_id.'<br>';
//    echo '$price_online = '.$price_online.'<br>';
//    echo '$protein = '.$protein.'<br>';
//    echo '$fat = '.$fat.'<br>';
//    echo '$carbohydrate = '.$carbohydrate.'<br>';
//    echo '$energy = '.$energy.'<br>';
//    echo '$store_min = '.$store_min.'<br>';
//    echo '$store_max = '.$store_max.'<br>';
//    echo '$store_online = '.$store_online.'<br>';
//    echo '$edit_id = '.$edit_id.'<br>';


    if (!isset($_POST['product_name']) || $product_name == '' ||
        !isset($_POST['unit_id']) || $unit_id == '' ||
        !isset($_POST['price_online']) || $price_online == '' ||
        !isset($_POST['store_online']) || $store_online == '' ||
        !isset($_POST['protein']) || $protein == '' ||
        !isset($_POST['fat']) || $fat == '' ||
        !isset($_POST['carbohydrate']) || $carbohydrate == '' ||
        !isset($_POST['energy']) || $energy == '' ||
        !isset($_POST['store_min']) || $store_min == '' ||
        !isset($_POST['store_max']) || $store_max == ''
    )
    {
        echo "<script>alert('Вы ввели не все данные!');</script>";
    }
    else if ($_POST['editrow'] == 'editrow') {
//        echo "Hi EDITOR!";
        $mysqli->query("
                        UPDATE `products`
                        SET
                            `product_name` = '$product_name',
                            `unit_id` = '$unit_id',
                            `price_online` =  '$price_online',
                            `protein` =  '$protein',
                            `fat` =  '$fat',
                            `carbohydrate` =  '$carbohydrate',
                            `energy` =  '$energy',
                            `store_min` =  '$store_min',
                            `store_max` =  '$store_max',
                            `store_online` =  '$store_online',
                            `last_update` = CURRENT_TIMESTAMP
                        WHERE  `product_id` = $edit_id;
                       ");

        $_POST['product_name'] = '-1';
        $_POST['unit_id'] = '-1';
        $_POST['price_online'] = '-1';
        $_POST['protein'] = '-1';
        $_POST['fat'] = '-1';
        $_POST['carbohydrate'] = '-1';
        $_POST['energy'] = '-1';
        $_POST['store_min'] = '-1';
        $_POST['store_max'] = '-1';
        $_POST['store_online'] = '-1';
        $_POST['editrow'] = '-1';
        $_GET['editrow'] = '-1';

    }
    else
    {
        $mysqli->query("
                        INSERT INTO `products`
                        (
                          `product_id`,
                          `product_name`,
                          `unit_id`,
                          `protein`,
                          `fat`,
                          `carbohydrate`,
                          `energy`,
                          `price_old`,
                          `price_online`,
                          `price_average`,
                          `price_offset`,
                          `store_min`,
                          `store_max`,
                          `store_online`
                        )
                        VALUES
                        (
                          NULL,
                          '$product_name',
                          '$unit_id',
                          '$protein',
                          '$fat',
                          '$carbohydrate',
                          '$energy',
                          '0',
                          '$price_online',
                          '0',
                          '0',
                          '$store_min',
                          '$store_max',
                          '$store_online'
                        );
                      ");

        $_POST['product_name'] = '-1';
        $_POST['unit_id'] = '-1';
        $_POST['price_online'] = '-1';
        $_POST['protein'] = '-1';
        $_POST['fat'] = '-1';
        $_POST['carbohydrate'] = '-1';
        $_POST['energy'] = '-1';
        $_POST['store_min'] = '-1';
        $_POST['store_max'] = '-1';
        $_POST['store_online'] = '-1';
    }
}



?>

<br>
<!-- Контейнер с навигацией -->
<div class="container">
    <div class="row">
        <!-- Navbar -->
        <nav class="navbar navbar-dark">
            <!-- Brand -->
            <a class="navbar-brand" href="#">Суши-Бар №1</a>
            <!-- Links -->
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Продажи</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Сырьё</a>
                    <div class="dropdown-menu" aria-labelledby="Data">
                        <a class="dropdown-item" href="product.php">Склад</a>
                        <a class="dropdown-item" href="#">Приход</a>
                        <a class="dropdown-item" href="#">Списание</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Данные</a>
                    <div class="dropdown-menu" aria-labelledby="Data">
                        <a class="dropdown-item" href="product.php">Продуты</a>
                        <a class="dropdown-item" href="semi.php">Полуфабрикаты</a>
                        <a class="dropdown-item" href="#">Комплекты</a>
                        <a class="dropdown-item" href="recipe.php">Рецепты</a>
                        <a class="dropdown-item" href="#">Блюда</a>
                        <a class="dropdown-item" href="#">Сеты</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Отчёты</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

    <div class="container">
        <div class="row">
            <br>
            <h1 class="display-1">Сырьё и упаковка</h1>
            <br>
            <form action="product.php" method="post">
                <button type="submit" name="showtype" value="show" class="btn btn-outline-info">Склад</button>
                <button type="submit" name="showtype" value="shop" class="btn btn-outline-success">Купить</button>
                <button type="submit" name="showtype" value="trash" class="btn btn-outline-danger">Списать</button>
            </form>

            <br>

            <?php



            if ($_POST['showtype'] == 'add' || $_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow' || isset($_GET['del']))
            {
            echo "
                <table class='table table-hover' id='products_tab'>
                    <thead>
                    <tr>
                        <th>№<br>п/п</th>
                        <th>Наименование</th>
                        <th>Ед.<br>изм.</th>
                        <th>Прежд.<br>Цена</th>
                        <th>Цена<br>онлайн</th>
                        <th>Ср.<br>цена</th>
                        <th>Откл.</th>
                        <th>Белки</th>
                        <th>Жиры</th>
                        <th>Угл.</th>
                        <th>Эн.<br>ценн.</th>
                        <th>Мин.<br>склад</th>
                        <th>Склад<br>онлайн</th>
                        <th>Макс.<br>склад</th>
                        <th>Редакт.</th>
                    </tr>
                    </thead>
                    <tbody>                    
                ";


                $result_set = $mysqli->query("SELECT * FROM `products` ORDER BY product_name");
                printTable ($result_set);


                echo "
                    </tbody>
                </table>

                <br>";

                // Заголовок поля формы добавления и редактирования данных
                if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow')
                            {
                                echo "<h4>Редактирование сырьевой позиции ";
                                $editquery = $mysqli->query("SELECT * FROM `products`") or die();
                                while (($editrr = $editquery->fetch_assoc()) != false)
                                {
                                    if ($edit_id == $editrr['product_id'])
                                    {
                                        echo "\"".$editrr['product_name']."\"";
                                    }
                                };
                                echo "</h4>";
                                echo "<div class='editform'>";
                            }
                            else
                            {
                                echo "<h4>Добавление новой сырьевой позиции</h4>";
                                echo "<div class='addform'>";
                            }

                echo "
                <form action='product.php' class='form-horizontal' method='post'>
                    <div class='container'>
                        <div class='row'>";


                // Наименование сырьевой позиции
                            echo "<div class='col-xs-6'>";

                    // Отображение для редактирования
                            if (($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow') && $_POST['product_name'] !== '0' && $_POST['product_name'] !== '')
                            {
                                echo "<div class='form-group has-warning'>";
                                $editquery = $mysqli->query("SELECT * FROM `products`") or die();
                                while (($editrr = $editquery->fetch_assoc()) != false)
                                {
                                    if ($edit_id == $editrr['product_id'])
                                    {
                                        echo "<input type='text' value='".$editrr['product_name']."' class='col-xs-3 form-control form-control-warning' id='product_name' name='product_name'>";
                                    }
                                };
                                echo "</div>";
                            }
                    // Отображение ПЕРВОГО внесения данных
                            else if (!isset($_POST['product_name']) || $_POST['product_name'] == '-1')
                            {
                                echo "<div class='form-group'>";
                                echo "<input type='text' placeholder='Наименование' class='col-xs-3 form-control' id='product_name' name='product_name'>";
                                echo "</div>";
                            }

                    // Отображение если ОШИБКА, данные не указаны для добавления или изменения
                            else if ($_POST['product_name'] == '0' || $_POST['product_name'] == '')
                            {
                                echo "<div class='form-group has-danger'>";
                                echo "<input type='text' placeholder='Наименование' class='col-xs-3 form-control form-control-danger' id='product_name' name='product_name'>";
                                echo "</div>";
                            }
                    // Отображение данных, когда все указано ВЕРНО
                            else
                            {
                                echo "<div class='form-group has-success'>";
                                echo "<input type='text' value='".$_POST['product_name']."' class='col-xs-3 form-control form-control-success' id='product_name' name='product_name'>";
                                echo "</div>";
                            }
                            echo "</div>";


                // Единицы измерения
                            echo " <div class='col-xs-2'>";
                    // Отображение для редактирования
                            if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow')
                            {
                                echo "<div class='form-group has-warning'>";
                                echo "<select class='form-control form-control-warning' id='unit_id' name='unit_id'>";
                                $ddquery = $mysqli->query("SELECT * FROM `units`") or die();
                                while (($dropd = $ddquery->fetch_assoc()) != false)
                                {
                                    if ($_POST['unit_id'] == $dropd['unit_id'])
                                    {
                                        echo "<option value='" . $dropd['unit_id'] . "'>" . $dropd['unit_name'] . "</option>";
                                    }
                                };
                                $ddquery = $mysqli->query("SELECT * FROM `units`") or die();
                                while (($dropd = $ddquery->fetch_assoc()) != false) {
                                    if ($_POST['unit_id'] !== $dropd['unit_id'])
                                    {
                                        echo "<option value='" . $dropd['unit_id'] . "'>" . $dropd['unit_name'] . "</option>";
                                    }
                                };
                                echo "</select>";
                                echo "</div>";
                            }
                    // Отображение ПЕРВОГО внесения данных
                            else if (!isset($_POST['unit_id']) || $_POST['unit_id'] == '-1')
                            {
                                echo "<div class='form-group'>";
                                echo "<select class='form-control' id='unit_id' name='unit_id'>";
                                echo "<option value='0'>Ед.изм.</option>";
                                $ddquery = $mysqli->query("SELECT * FROM `units`") or die();
                                while (($dropd = $ddquery->fetch_assoc()) != false) {
                                    echo "<option value='" . $dropd['unit_id'] . "'>" . $dropd['unit_name'] . "</option>";
                                };
                                echo "</select>";
                                echo "</div>";
                            }
                    // Отображение если ОШИБКА, данные не указаны для добавления или изменения
                            else if ($_POST['unit_id'] == '0' || $_POST['unit_id'] == '')
                            {
                                echo "<div class='form-group has-danger'>";
                                echo "<select class='form-control form-control-danger' id='unit_id' name='unit_id'>";
                                echo "<option value='0'>Не указ!</option>";
                                $ddquery = $mysqli->query("SELECT * FROM `units`") or die();
                                while (($dropd = $ddquery->fetch_assoc()) != false) {
                                    echo "<option value='" . $dropd['unit_id'] . "'>" . $dropd['unit_name'] . "</option>";
                                };
                                echo "</select>";
                                echo "</div>";
                            }
                    // Отображение данных, когда все указано ВЕРНО
                            else
                            {
                                echo "<div class='form-group has-success'>";
                                echo "<select class='form-control form-control-success' id='unit_id' name='unit_id'>";
                                $ddquery = $mysqli->query("SELECT * FROM `units`") or die();
                                while (($dropd = $ddquery->fetch_assoc()) != false)
                                {
                                    if ($_POST['unit_id'] == $dropd['unit_id'])
                                    {
                                        echo "<option value='" . $dropd['unit_id'] . "'>" . $dropd['unit_name'] . "</option>";
                                    }
                                };
                                $ddquery = $mysqli->query("SELECT * FROM `units`") or die();
                                while (($dropd = $ddquery->fetch_assoc()) != false) {
                                    if ($_POST['unit_id'] !== $dropd['unit_id'])
                                    {
                                        echo "<option value='" . $dropd['unit_id'] . "'>" . $dropd['unit_name'] . "</option>";
                                    }
                                };
                                echo "</select>";
                                echo "</div>";
                            }
                            echo "</div>";

                
                // Цена
                            echo "<div class='col-xs-4'>";
                    // Отображение для редактирования
                            if (($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow') && $_POST['price_online'] !== '0' && $_POST['price_online'] !== '')
                            {
                                echo "<div class='input-group form-group has-warning'>";
                                $editquery = $mysqli->query("SELECT * FROM `products`") or die();
                                while (($editrr = $editquery->fetch_assoc()) != false)
                                {
                                    if ($edit_id == $editrr['product_id'])
                                    {
                                        echo "<input type='text' value='".$editrr['price_online']."' class='col-xs-3 form-control form-control-warning' id='price_online' name='price_online'>";
                                    }
                                };
                                echo "<span class='input-group-addon'>руб.</span>";
                                echo "</div>";
                            }
                    // Отображение ПЕРВОГО внесения данных
                            else if (!isset($_POST['price_online']) || $_POST['price_online'] == '-1')
                            {
                                echo "<div class='form-group'>";
                                echo "<div class='input-group'>";
                                echo "<input type='text' placeholder='Цена' class='col-xs-3 form-control' id='price_online' name='price_online'>";
                                echo "<span class='input-group-addon'>руб.</span>";
                                echo "</div>";
                                echo "</div>";
                            }
                    // Отображение если ОШИБКА, данные не указаны для добавления или изменения
                            else if ($_POST['price_online'] == '0' || $_POST['price_online'] == '')
                            {
                                echo "<div class='input-group form-group has-danger'>";
                                echo "<input type='text' placeholder='Цена' class='col-xs-3 form-control form-control-danger' id='price_online' name='price_online'>";
                                echo "<span class='input-group-addon'>руб.</span>";
                                echo "</div>";
                            }
                    // Отображение данных, когда все указано ВЕРНО
                            else
                            {
                                echo "<div class='form-group has-success'>";
                                echo "<div class='input-group'>";
                                echo "<input type='text' value='".$_POST['price_online']."' class='col-xs-3 form-control form-control-success' id='price_online' name='price_online'>";
                                echo "<span class='input-group-addon'>руб.</span>";
                                echo "</div>";
                                echo "</div>";
                            }
                            echo "</div>";


                        echo "</div>
                        <div class='form-group row'>";


                // Содержание Белка в 100 г. сыръевой позиции
                            echo "<div class='col-xs-3'>";
                    // Отображение для редактирования
                            if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow')
                            {
                                echo "<div class='form-group has-warning'>";
                                $editquery = $mysqli->query("SELECT * FROM `products`") or die();
                                while (($editrr = $editquery->fetch_assoc()) != false)
                                {
                                    if ($edit_id == $editrr['product_id'])
                                    {
                                        echo "<input type='text' value='".$editrr['protein']."' class='col-xs-3 form-control form-control-warning' id='protein' name='protein'>";
                                    }
                                };
                                echo "</div>";
                            }
                    // Отображение ПЕРВОГО внесения данных
                            else if (!isset($_POST['protein']) || $_POST['protein'] == '-1')
                            {
                                echo "<div class='form-group'>";
                                echo "<input type='text' 
										placeholder='Белки'
										class='col-xs-3 form-control'
										id='protein'
										name='protein'
										>";
                                echo "</div>";
                            }
                    // Отображение если ОШИБКА, данные не указаны для добавления или изменения
                            else if ($_POST['protein'] == '0' || $_POST['protein'] == '')
                            {
                                echo "<div class='form-group has-danger'>";
                                echo "<input type='text' placeholder='Белки' class='col-xs-3 form-control form-control-danger' id='protein' name='protein'>";
                                echo "</div>";
                            }
                    // Отображение данных, когда все указано ВЕРНО
                            else
                            {
                                echo "<div class='form-group has-success'>";
                                echo "<input type='text' value='".$_POST['protein']."' class='col-xs-3 form-control form-control-success' id='protein' name='protein'>";
                                echo "</div>";
                            }
                            echo "</div>";


                // Содержание Жиров в 100 г. сыръевой позиции
                            echo "<div class='col-xs-3'>";
                    // Отображение для редактирования
                            if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow')
                            {
                                echo "<div class='form-group has-warning'>";
                                $editquery = $mysqli->query("SELECT * FROM `products`") or die();
                                while (($editrr = $editquery->fetch_assoc()) != false)
                                {
                                    if ($edit_id == $editrr['product_id'])
                                    {
                                        echo "<input type='text' value='".$editrr['fat']."' class='col-xs-3 form-control form-control-warning' id='fat' name='fat'>";
                                    }
                                };
                                echo "</div>";
                            }
                    // Отображение ПЕРВОГО внесения данных
                            else if (!isset($_POST['fat']) || $_POST['fat'] == '-1')
                            {
                                echo "<div class='form-group'>";
                                echo "<input type='text' placeholder='Жиры' class='col-xs-3 form-control' id='fat' name='fat'>";
                                echo "</div>";
                            }
                    // Отображение если ОШИБКА, данные не указаны для добавления или изменения
                            else if ($_POST['fat'] == '0' || $_POST['fat'] == '')
                            {
                                echo "<div class='form-group has-danger'>";
                                echo "<input type='text' placeholder='Жиры' class='col-xs-3 form-control form-control-danger' id='fat' name='fat'>";
                                echo "</div>";
                            }
                    // Отображение данных, когда все указано ВЕРНО
                            else
                            {
                                echo "<div class='form-group has-success'>";
                                echo "<input type='text' value='".$_POST['fat']."' class='col-xs-3 form-control form-control-success' id='fat' name='fat'>";
                                echo "</div>";
                            }
                            echo "</div>";


                // Содержание Углеводов в 100 г. сыръевой позиции
                            echo "<div class='col-xs-3'>";
                    // Отображение для редактирования
                            if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow')
                            {
                                echo "<div class='form-group has-warning'>";
                                $editquery = $mysqli->query("SELECT * FROM `products`") or die();
                                while (($editrr = $editquery->fetch_assoc()) != false)
                                {
                                    if ($edit_id == $editrr['product_id'])
                                    {
                                        echo "<input type='text' value='".$editrr['carbohydrate']."' class='col-xs-3 form-control form-control-warning' id='carbohydrate' name='carbohydrate'>";
                                    }
                                };
                                echo "</div>";
                            }
                    // Отображение ПЕРВОГО внесения данных
                            else if (!isset($_POST['carbohydrate']) || $_POST['carbohydrate'] == '-1')
                            {
                                echo "<div class='form-group'>";
                                echo "<input type='text' placeholder='Углеводы' class='col-xs-3 form-control' id='carbohydrate' name='carbohydrate'>";
                                echo "</div>";
                            }
                    // Отображение если ОШИБКА, данные не указаны для добавления или изменения
                            else if ($_POST['carbohydrate'] == '0' || $_POST['carbohydrate'] == '')
                            {
                                echo "<div class='form-group has-danger'>";
                                echo "<input type='text' placeholder='Углеводы' class='col-xs-3 form-control form-control-danger' id='carbohydrate' name='carbohydrate'>";
                                echo "</div>";
                            }
                    // Отображение данных, когда все указано ВЕРНО
                            else
                            {
                                echo "<div class='form-group has-success'>";
                                echo "<input type='text' value='".$_POST['carbohydrate']."' class='col-xs-3 form-control form-control-success' id='carbohydrate' name='carbohydrate'>";
                                echo "</div>";
                            }
                            echo "</div>";


                // Энергетическая ценность в 100 г. сыръевой позиции
                            echo "<div class='col-xs-3'>";
                    // Отображение для редактирования
                            if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow')
                            {
                                echo "<div class='form-group has-warning'>";
                                $editquery = $mysqli->query("SELECT * FROM `products`") or die();
                                while (($editrr = $editquery->fetch_assoc()) != false)
                                {
                                    if ($edit_id == $editrr['product_id'])
                                    {
                                        echo "<input type='text' value='".$editrr['energy']."' class='col-xs-3 form-control form-control-warning' id='energy' name='energy'>";
                                    }
                                };
                                echo "</div>";
                            }
                    // Отображение ПЕРВОГО внесения данных
                            else if (!isset($_POST['energy']) || $_POST['energy'] == '-1')
                            {
                                echo "<div class='form-group'>";
                                echo "<input type='text' placeholder='Эн.ценность' class='col-xs-3 form-control' id='energy' name='energy'>";
                                echo "</div>";
                            }
                    // Отображение если ОШИБКА, данные не указаны для добавления или изменения
                            else if ($_POST['energy'] == '0' || $_POST['energy'] == '')
                            {
                                echo "<div class='form-group has-danger'>";
                                echo "<input type='text' placeholder='Эн.ценность' class='col-xs-3 form-control form-control-danger' id='energy' name='energy'>";
                                echo "</div>";
                            }
                    // Отображение данных, когда все указано ВЕРНО
                            else
                            {
                                echo "<div class='form-group has-success'>";
                                echo "<input type='text' value='".$_POST['energy']."' class='col-xs-3 form-control form-control-success' id='energy' name='energy'>";
                                echo "</div>";
                            }
                            echo "</div>";


                            echo "</div>
                            <div class='form-group row'>";


                // Минимальный запас на складе
                            echo "<div class='col-xs-3'>";
                    // Отображение для редактирования
                            if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow')
                            {
                                echo "<div class='form-group has-warning'>";
                                $editquery = $mysqli->query("SELECT * FROM `products`") or die();
                                while (($editrr = $editquery->fetch_assoc()) != false)
                                {
                                    if ($edit_id == $editrr['product_id'])
                                    {
                                        echo "<input type='text' value='".$editrr['store_min']."' class='col-xs-3 form-control form-control-warning' id='store_min' name='store_min'>";
                                    }
                                };
                                echo "</div>";
                            }
                    // Отображение ПЕРВОГО внесения данных
                            else if (!isset($_POST['store_min']) || $_POST['store_min'] == '-1')
                            {
                                echo "<div class='form-group'>";
                                echo "<input type='text' placeholder='Мин.склад' class='col-xs-3 form-control' id='store_min' name='store_min'>";
                                echo "</div>";
                            }
                    // Отображение если ОШИБКА, данные не указаны для добавления или изменения
                            else if ($_POST['store_min'] == '0' || $_POST['store_min'] == '')
                            {
                                echo "<div class='form-group has-danger'>";
                                echo "<input type='text' placeholder='Мин.склад' class='col-xs-3 form-control form-control-danger' id='store_min' name='store_min'>";
                                echo "</div>";
                            }
                    // Отображение данных, когда все указано ВЕРНО
                            else
                            {
                                echo "<div class='form-group has-success'>";
                                echo "<input type='text' value='".$_POST['store_min']."' class='col-xs-3 form-control form-control-success' id='store_min' name='store_min'>";
                                echo "</div>";
                            }
                            echo "</div>";

                
                // Текущее состояние склада
                            echo "<div class='col-xs-3'>";
                    // Отображение для редактирования
                            if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow')
                            {
                                echo "<div class='form-group has-warning'>";
                                $editquery = $mysqli->query("SELECT * FROM `products`") or die();
                                while (($editrr = $editquery->fetch_assoc()) != false)
                                {
                                    if ($edit_id == $editrr['product_id'])
                                    {
                                        echo "<input type='text' value='".$editrr['store_online']."' class='col-xs-3 form-control form-control-warning' id='store_online' name='store_online'>";
                                    }
                                };
                                echo "</div>";
                            }
                    // Отображение ПЕРВОГО внесения данных
                            else if (!isset($_POST['store_online']) || $_POST['store_online'] == '-1')
                            {
                                echo "<div class='form-group'>";
                                echo "<input type='text' placeholder='Склад онлайн' class='col-xs-3 form-control' id='store_online' name='store_online'>";
                                echo "</div>";
                            }
                    // Отображение если ОШИБКА, данные не указаны для добавления или изменения
                            else if ($_POST['store_online'] == '0' || $_POST['store_online'] == '')
                            {
                                echo "<div class='form-group has-danger'>";
                                echo "<input type='text' placeholder='Склад онлайн' class='col-xs-3 form-control form-control-danger' id='store_online' name='store_online'>";
                                echo "</div>";
                            }
                    // Отображение данных, когда все указано ВЕРНО
                            else
                            {
                                echo "<div class='form-group has-success'>";
                                echo "<input type='text' value='".$_POST['store_online']."' class='col-xs-3 form-control form-control-success' id='store_online' name='store_online'>";
                                echo "</div>";
                            }
                            echo "</div>";

                
                // Максимальный запас на складе
                            echo "<div class='col-xs-3'>";
                    // Отображение для редактирования
                            if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow')
                            {
                                echo "<div class='form-group has-warning'>";
                                $editquery = $mysqli->query("SELECT * FROM `products`") or die();
                                while (($editrr = $editquery->fetch_assoc()) != false)
                                {
                                    if ($edit_id == $editrr['product_id'])
                                    {
                                        echo "<input type='text' value='".$editrr['store_max']."' class='col-xs-3 form-control form-control-warning' id='store_max' name='store_max'>";
                                    }
                                };
                                echo "</div>";
                            }
                    // Отображение ПЕРВОГО внесения данных
                            else if (!isset($_POST['store_max']) || $_POST['store_max'] == '-1')
                            {
                                echo "<div class='form-group'>";
                                echo "<input type='text' placeholder='Макс.склад' class='col-xs-3 form-control' id='store_max' name='store_max'>";
                                echo "</div>";
                            }
                    // Отображение если ОШИБКА, данные не указаны для добавления или изменения
                            else if ($_POST['store_max'] == '0' || $_POST['store_max'] == '')
                            {
                                echo "<div class='form-group has-danger'>";
                                echo "<input type='text' placeholder='Макс.склад' class='col-xs-3 form-control form-control-danger' id='store_max' name='store_max'>";
                                echo "</div>";
                            }
                    // Отображение данных, когда все указано ВЕРНО
                            else
                            {
                                echo "<div class='form-group has-success'>";
                                echo "<input type='text' value='".$_POST['store_max']."' class='col-xs-3 form-control form-control-success' id='store_max' name='store_max'>";
                                echo "</div>";
                            }
                            echo "</div>";


                // Кнопики [Внести изменения] и [Добавить]
                            echo "<div class='col-xs-3'>";
                    // Отображение для редактирования
                            if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow')
                            {
                                echo "<input type='hidden' name='editrow' value='editrow'>";
                                echo "<input type='hidden' name='edit_id' value='".$edit_id."'>";
                                echo "<input type='hidden' name='showtype' value='add'>";
                                echo "<button type='submit' name='add' value='submit' class='btn btn-outline-warning pull-right'>Внести изменение</button>";
                            }
                    // Отображение ПЕРВОГО внесения данных
                            else
                            {
                                echo "<input type='hidden' name='showtype' value='add'>";
                                echo "<button type='submit' name='add' value='submit' class='btn btn-outline-primary pull-right'>Добавить</button>";
                            }
                            echo "</div>";

            echo "
                        </div>
                    </div>
                </form>
                </div>
                    
            ";

            } else {



            echo "
            <table class='table table-hover'>
                <thead>
                <tr>
                    <th>№ п/п</th>
                    <th>Наименование</th>
                    <th>Преждняя цена</th>
                    <th>Цена онлайн</th>
                    <th>Отклонение</th>
                    <th>Склад онлайн</th>
                    <th>Ед.изм.</th>
                </tr>
                </thead>

                <tbody>

                ";

                $result_set = $mysqli->query("SELECT * FROM `products` ORDER BY product_name");
                showTable ($result_set, $unit_set);

            echo "
                </tbody>
            </table>
		
	    <br>
            <form class='form-inline' action='product.php' method='post'>
				<input type='password' placeholder='Пароль для редактирования' class='form-control' id='passforedit' name='passforedit'>
                <button type='submit' name='showtype' value='add' class='btn btn-outline-success'>Добавить данные</button>
            </form>
            ";

            }

            ?>

            
        </div>
    </div>
    <br><br><br>

    <?php

    $mysqli->close();

    ?>
   
                
        <!-- jQuery first, then Tether, then Bootstrap JS. -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>

        <!-- Подключение jQuery плагина jqBootstrapValidation -->
		<!--                 НЕ ИСПОЛЬЗУЮ                     -->
        <!-- http://reactiveraven.github.io/jqBootstrapValidation/ -->
        <!-- Скачать плагин тут https://github.com/ReactiveRaven/jqBootstrapValidation -->
        <!-- <script src="/assets/js/jqBootstrapValidation.min.js"></script> -->
        <!-- <script> -->
        <!--     $(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } ); -->
        <!-- </script> -->
    </body>
</html>