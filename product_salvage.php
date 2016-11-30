<?php

session_start();
if (!isset($_SESSION['login'])) {
    $_SESSION['page'] = $_SERVER['REQUEST_URI'];
    header("Location: http://bar-1.ru/_sushi/index.php?authorization");
    exit;
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Закуп сырья и упаковки</title>

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
        <a name='del' href='index.php?del={$row["product_id"]}'>
        <i class='fa fa-times fa-2x' aria-hidden='true' style='color: red;'></i>
        </a>

        &nbsp;&nbsp;&nbsp;&nbsp;

        <a name='edit' href='index.php?editrow=editrow&edit_id={$row["product_id"]}'>
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

// Добавление данных в таблицу product_purchase
if ($_POST['add'] == 'submit' || $_POST['editrow'] == 'editrow')
{
    $ppurch_date = $_POST['ppurch_date'];
    $fiscal_receipt = $_POST['fiscal_receipt'];
    $vendor_id = $_POST['vendor_id'];
    $product_id = $_POST['product_id'];
    $product_amount = $_POST['product_amount'];
    $product_cost = $_POST['product_cost'];
    $ppurch_comment = $_POST['ppurch_comment'];


    echo "$ppurch_date = ".$ppurch_date;
    echo "$fiscal_receipt = ".$fiscal_receipt;
    echo "$vendor_id = ".$vendor_id;
    echo "$product_id = ".$product_id;
    echo "$product_amount = ".$product_amount;
    echo "$product_cost = ".$product_cost;
    echo "$ppurch_comment = ".$ppurch_comment;


    if (!isset($_POST['ppurch_date']) || $ppurch_date == '' ||
        !isset($_POST['fiscal_receipt']) || $fiscal_receipt == '' ||
        !isset($_POST['vendor_id']) || $vendor_id == '' ||
        !isset($_POST['product_id']) || $product_id == '' ||
        !isset($_POST['product_amount']) || $product_amount == '' ||
        !isset($_POST['product_cost']) || $product_cost == '' ||
        !isset($_POST['ppurch_comment']) || $ppurch_comment == ''
    )
    {
        echo "<script>alert('Вы ввели не все данные!');</script>";
    }
    else if ($_POST['editrow'] == 'editrow') {
//        echo "Hi EDITOR!";
        $product_price = $product_cost / $product_amount;
        $mysqli->query("
                        UPDATE `products`
                        SET
                            `ppurch_date` = '$ppurch_date',
                            `fiscal_receipt` = '$fiscal_receipt',
                            `vendor_id` =  '$vendor_id',
                            `product_id` =  '$product_id',
                            `product_amount` =  '$product_amount',
                            `product_cost` =  '$product_cost',
                            `product_price` = '$product_price',
                            `ppurch_comment` =  '$ppurch_comment',
                            `last_update` = CURRENT_TIMESTAMP
                        WHERE  `product_id` = $edit_id;
                       ");

        $_POST['ppurch_date'] = '-1';
        $_POST['fiscal_receipt'] = '-1';
        $_POST['vendor_id'] = '-1';
        $_POST['product_id'] = '-1';
        $_POST['product_amount'] = '-1';
        $_POST['product_cost'] = '-1';
        $_POST['ppurch_comment'] = '-1';
    }
    else
    {
        $product_price = $product_cost / $product_amount;
        $mysqli->query("
                        INSERT INTO `products`
                        (
                          `ppurch_id`,
                          `ppurch_date`,
                          `fiscal_receipt`,
                          `vendor_id`,
                          `product_id`,
                          `product_amount`,
                          `product_cost`,
                          `product_price`,
                          `ppurch_comment`
                        )
                        VALUES
                        (
                          NULL,
                          '$ppurch_date',
                          '$fiscal_receipt',
                          '$vendor_id',
                          '$product_id',
                          '$product_amount',
                          '$product_cost',
                          '$product_price',
                          '$ppurch_comment'
                        );
                      ");

        $_POST['ppurch_date'] = '-1';
        $_POST['fiscal_receipt'] = '-1';
        $_POST['vendor_id'] = '-1';
        $_POST['product_id'] = '-1';
        $_POST['product_amount'] = '-1';
        $_POST['product_cost'] = '-1';
        $_POST['ppurch_comment'] = '-1';
    }
}



?>

    <br>
    <div class="container">
        <div class="row">
            <!-- Navbar -->
            <nav class="navbar navbar-dark">
                <!-- Brand -->
                <a class="navbar-brand" href="http://www.proskurnin.ru/_sushi/index.php">Суши-Бар №1</a>
                <!-- Links -->
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Продажи</a>
                    </li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Сырьё</a>
						<div class="dropdown-menu" aria-labelledby="Data">
							<a class="dropdown-item" href="#">Склад</a>
							<a class="dropdown-item" href="#">Приход</a>
							<a class="dropdown-item" href="#">Списание</a>
						</div>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Данные</a>
						<div class="dropdown-menu" aria-labelledby="Data">
							<a class="dropdown-item" href="#">Блюда</a>
							<a class="dropdown-item" href="#">Рецепты</a>
							<a class="dropdown-item" href="#">Сеты</a>
							<a class="dropdown-item" href="#">Полуфабрикаты</a>
							<a class="dropdown-item" href="#">Комплекты</a>
							<a class="dropdown-item" href="#">Продуты</a>
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
            <h1 class="display-1">Покупка сырья</h1>
            <br>
            <form action="index.php" method="post">
                <button type="submit" name="showtype" value="show" class="btn btn-outline-info">Склад</button>
                <button type="submit" name="showtype" value="shop" class="btn btn-outline-success">Купить</button>
                <button type="submit" name="showtype" value="trash" class="btn btn-outline-danger">Списать</button>




            </form>

            <br>


            <?php




// ФОРМА работы с данными

            // Заголовок поля формы добавления и редактирования данных
            if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow')
            {
                echo "<h4>Редактирование чека закупа ";
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
                echo "<h4>Добавление нового чека</h4>";
                echo "<div class='addform'>";
            }

            echo "
                <form action='index.php' class='form-horizontal' method='post'>
                    <div class='container'>
                        <div class='row'>";


// Дата покупки
            echo "<div class='col-xs-4'>";
            // Отображение для редактирования
            if (($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow') && $_POST['price_online'] !== '0' && $_POST['price_online'] !== '')
            {
                echo "<div class='form-group has-warning'>";
                echo "<div class='input-group'>";
                $editquery = $mysqli->query("SELECT * FROM `products`") or die();
                while (($editrr = $editquery->fetch_assoc()) != false)
                {
                    if ($edit_id == $editrr['product_id'])
                    {
                        echo "<input type='text' value='".$editrr['price_online']."' class='col-xs-3 form-control form-control-warning' id='price_online' name='price_online'>";
                    }
                };
                echo "<span class='input-group-addon'><i class='fa fa-calendar' aria-hidden='true'></i></span>";
                echo "</div>";
                echo "</div>";
            }
            // Отображение ПЕРВОГО внесения данных
            else if (!isset($_POST['price_online']) || $_POST['price_online'] == '-1')
            {
                echo "<div class='form-group'>";
                echo "<div class='input-group'>";
                echo "<input type='text' placeholder='ДД.ММ.ГГГГ' class='col-xs-3 form-control' id='price_online' name='price_online'>";
                echo "<span class='input-group-addon'><i class='fa fa-calendar' aria-hidden='true'></i></span>";
                echo "</div>";
                echo "</div>";
            }
            // Отображение если ОШИБКА, данные не указаны для добавления или изменения
            else if ($_POST['price_online'] == '0' || $_POST['price_online'] == '')
            {
                echo "<div class='form-group has-danger'>";
                echo "<div class='input-group'>";
                echo "<input type='text' placeholder='ДД.ММ.ГГГГ' class='col-xs-3 form-control form-control-danger' id='price_online' name='price_online'>";
                echo "<span class='input-group-addon datepickerbutton'><i class='fa fa-calendar' aria-hidden='true'></i></span>";
                echo "</div>";
                echo "</div>";
            }
            // Отображение данных, когда все указано ВЕРНО
            else
            {
                echo "<div class='form-group has-success'>";
                echo "<div class='input-group'>";
                echo "<input type='text' value='".$_POST['price_online']."' class='col-xs-3 form-control form-control-success' id='price_online' name='price_online'>";
                echo "<span class='input-group-addon'><i class='fa fa-calendar' aria-hidden='true'></i></span>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";


// Номер чека покупки
            echo "<div class='col-xs-4'>";
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
                echo "<input type='text' placeholder='Номер чека' class='col-xs-3 form-control' id='fat' name='fat'>";
                echo "</div>";
            }
            // Отображение если ОШИБКА, данные не указаны для добавления или изменения
            else if ($_POST['fat'] == '0' || $_POST['fat'] == '')
            {
                echo "<div class='form-group has-danger'>";
                echo "<input type='text' placeholder='Номер чека' class='col-xs-3 form-control form-control-danger' id='fat' name='fat'>";
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


// Поставщик
            echo " <div class='col-xs-4'>";
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
                echo "<option value='0'>Поставщик</option>";
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



            echo "      </div>
                        <div class='row'>";

// Наименование сырьевой позиции

            echo " <div class='col-xs-4'>";
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
                echo "<option value='0'>Сырьевая позиция</option>";
                $ddquery = $mysqli->query("SELECT * FROM `products`") or die();
                while (($dropd = $ddquery->fetch_assoc()) != false) {
                    echo "<option value='" . $dropd['productt_id'] . "'>" . $dropd['product_name'] . "</option>";
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


// Количество по приходу
            echo "<div class='col-xs-2'>";
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
                echo "<input type='text' placeholder='Количество' class='col-xs-3 form-control' id='price_online' name='price_online'>";
                echo "<span class='input-group-addon'>кг.</span>";
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


// Сумма оплачена за приход
            echo "<div class='col-xs-2'>";
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
                echo "<input type='text' placeholder='Оплачено' class='col-xs-3 form-control' id='price_online' name='price_online'>";
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



// Комментарий к покупке данного товара
            echo "<div class='col-xs-4'>";
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
                echo "<input type='text' placeholder='Комментарий' class='col-xs-3 form-control' id='store_min' name='store_min'>";
                echo "</div>";
            }
            // Отображение если ОШИБКА, данные не указаны для добавления или изменения
            else if ($_POST['store_min'] == '0' || $_POST['store_min'] == '')
            {
                echo "<div class='form-group has-danger'>";
                echo "<input type='text' placeholder='Комментарий' class='col-xs-3 form-control form-control-danger' id='store_min' name='store_min'>";
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






            echo "    </div>
                      <div class='form-group row'>";





            // Кнопки [Внести изменения] и [Добавить]
            echo "<div class='col-xs-12'>";


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
                echo "<button type='submit' name='add' value='submit' class='btn btn-outline-primary pull-right'>Купить</button>";
            }
            echo "</div>";

            echo "
                        </div>
                    </div>
                </form>
                </div>
                    
            ";


// Конец ФОРМЫ





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


                $result_set = $mysqli->query("SELECT * FROM `products`");
                printTable ($result_set);


                echo "
                    </tbody>
                </table>

                <br>";


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

                $result_set = $mysqli->query("SELECT * FROM `products`");
                showTable ($result_set, $unit_set);

                echo "
                </tbody>
            </table>
		
	    <br>
            <form class='form-inline' action='index.php' method='post'>
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

        <script type="text/javascript">
            function addField () {
                var telnum = parseInt($("#add_field_area").find("div.add:last").attr("id").slice(3)) 1;

                $("div#add_field_area").append("<div id="add" telnum "" class="add"><label> Поле №" telnum "</label><input type="text" width="120" name="val[]" id="val"  value=""/></div>");
            }
        </script>


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