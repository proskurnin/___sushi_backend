<!DOCTYPE html>
<html lang="ru">
<?php


// Адрес страницы во всех формах
$urlform = 'product.php';
// Название таблицы БД, с которой работаем, добавляется в конце s. Имеем имяs
// Поле имя в данной таблице обызательно имя_name
// Поле id, если нужно, имеет вид имя_id. Связи таблиц решил делать через name. Нужно чтобы было уникальным.
$tabname = 'product';

// Пароль на редактирование данной страницы
$password = '11';
// Включение ДИАГНОСТИКИ переменных (on/off)
$diagnostics_var = 'on';
// Включение ДИАГНОСТИКИ событий (on/off)
$diagnostics_event = 'on';



?>
<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Склад</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="sha384-2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">

    <!-- Font Awesome CSS -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">

    <!-- Шрифт от Google - Roboto -->
    <!-- Мы используем только Roboto жирностью и начертанием:
         Light 300, Light 300 Italic,
         Normal 400, Normal 400,
         Medium 500, Medium 500 Italic -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,400italic,500italic,300,300italic' rel='stylesheet' type='text/css'>

    <!-- My oun CSS -->
    <link rel="stylesheet" href="assets/css/sushi.css">

</head>
<body>


<?php
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
//
//             В ЭТОМ РАЗДЕЛЕ СОБРАНЫ ВСЕ ФУНКЦИИ ИЗ ДОКУМЕНТА
//
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =


//                   Строим таблицу
//   ПРОСМОТР - ДОБАВЛЕНИЕ - УДАЛЕНИЕ - РЕДАКТИРОВАНИЕ

function showTable ($result_set,$tabname,$nutr_val,$edbutt,$diagnostics_tab)
{

    $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
    $mysqli->query("SET NAMES 'utf8'");

    $npp = 0;
    $item_name = '';
    $item_name_check = '';


    while (($row = $result_set->fetch_assoc()) != false) {

        $item_name = $row[$tabname . '_name'];
        $npp++;

        echo "<tr>";
        echo "<td>" . $npp . "</td>";
        echo "<td>" . $row["product_name"] . "</td>";
        echo "<td>";

        $mysqlg = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
        $mysqlg->query("SET NAMES 'utf8'");

        $query = "SELECT * FROM `units` ORDER BY  unit_name";
        $unit_set = $mysqlg->query($query) or die($query);
        while (($urow = $unit_set->fetch_assoc()) != false) {
            if ($row['unit_id'] == $urow['unit_id']) {
                echo $urow['unit_name'];
            }
        }
        $mysqlg->close();


        $zerro_style = "style='color: #000;'";
        echo "</td>";

        if($row["price_old"] == '0' || $row["price_old"] == '') {$zerro_style = "style='color: #ccc;'";} else {$zerro_style = "style='color: #000;'";};
        echo "<td class='td-right' ".$zerro_style.">" . number_format($row["price_old"], 2, ',', ' ') . "</td>";

        if($row["price_online"] == '0' || $row["price_online"] == '') {$zerro_style = "style='color: #ccc;'";} else {$zerro_style = "style='color: #f00;'";};
        echo "<td class='td-right' ".$zerro_style.">" . number_format($row["price_online"], 2, ',', ' ') . "</td>";

        if ($edbutt == '1') {
            if($row["price_average"] == '0' || $row["price_average"] == '') {$zerro_style = "style='color: #ccc;'";} else {$zerro_style = "style='color: #000;'";};
            echo "<td class='td-right' ".$zerro_style.">" . number_format($row["price_average"], 2, ',', ' ') . "</td>";
        }

        if($row["price_offset"] == '0' || $row["price_offset"] == '') {$zerro_style = "style='color: #ccc;'";} else {$zerro_style = "style='color: #000;'";};
        echo "<td class='td-right' ".$zerro_style.">" . number_format($row["price_offset"], 3, ',', ' ') . "</td>";

        if ($edbutt == '1') {
            if($row["protein"] == '0' || $row["protein"] == '') {$zerro_style = "style='color: #ccc;'";} else {$zerro_style = "style='color: #83FF6B;'";};
            echo "<td class='td-right' ".$zerro_style.">" . number_format($row["protein"], 3, ',', ' ') . "</td>";
            if($row["fat"] == '0' || $row["fat"] == '') {$zerro_style = "style='color: #ccc;'";} else {$zerro_style = "style='color: #FFB967;'";};
            echo "<td class='td-right' ".$zerro_style.">" . number_format($row["fat"], 3, ',', ' ') . "</td>";
            if($row["carbohydrate"] == '0' || $row["carbohydrate"] == '') {$zerro_style = "style='color: #ccc;'";} else {$zerro_style = "style='color: #A2BFFF;'";};
            echo "<td class='td-right' ".$zerro_style.">" . number_format($row["carbohydrate"], 3, ',', ' ') . "</td>";
            if($row["energy"] == '0' || $row["energy"] == '') {$zerro_style = "style='color: #ccc;'";} else {$zerro_style = "style='color: #FF929A;'";};
            echo "<td class='td-right' ".$zerro_style.">" . number_format($row["energy"], 3, ',', ' ') . "</td>";
            if($row["store_min"] == '0' || $row["store_min"] == '') {$zerro_style = "style='color: #ccc;'";} else {$zerro_style = "style='color: #000;'";};
            echo "<td class='td-right' ".$zerro_style.">" . number_format($row["store_min"], 3, ',', ' ') . "</td>";
        }
        if($row["store_online"] == '0' || $row["store_online"] == '') {$zerro_style = "style='color: #ccc;'";} else {$zerro_style = "style='color: #f00;'";};
        echo "<td class='td-right' ".$zerro_style.">" . number_format($row["store_online"], 3, ',', ' ') . "</td>";
        if ($edbutt == '1') {
            if($row["store_max"] == '0' || $row["store_max"] == '') {$zerro_style = "style='color: #ccc;'";} else {$zerro_style = "style='color: #000;'";};
            echo "<td class='td-right' ".$zerro_style.">" . number_format($row["store_max"], 3, ',', ' ') . "</td>";
            echo "<td class='td-right'>

            <!-- Button trigger modal -->
            <a name='modal' href=" . $urlform . "?item=" . urlencode($item_name) . " data-toggle='modal' data-target='#myModal'>
            <i class='fa fa-info-circle fa-2x' aria-hidden='true' style='color: #003cff;'></i></a>
                    
            &nbsp;&nbsp;
            
            <a name='del' href=" .$urlform."?del=".urlencode($item_name).">
            <i class='fa fa-times fa-2x' aria-hidden='true' style='color: red;'></i></a>
    
            &nbsp;&nbsp;
    
            <a name='edit' href=" . $urlform . "?editrow=editrow&edit_name=".urlencode($item_name). ">
            <i class='fa fa-pencil-square-o fa-2x' aria-hidden='true' style='color: #05ed00;'></i></a>
            </td>";
        }
        echo "</tr>";

    }
    $mysqli->close();
}


//    Функция удаления данных из рабочей таблицы

function rowdelete ($del,$tabname) {
    $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
    $mysqli->query("SET NAMES 'utf8'");
    $query = "DELETE FROM `{$tabname}s` WHERE `{$tabname}_name` = '$del'";
    /* Выполняем запрос. Если произойдет ошибка - вывести ее. */
    $mysqli->query($query) or die($query);
    $mysqli->close();
}


//        Функция подсчёта количества строк

function rowscounter ($row_name,$tabname){
    $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
    $mysqli->query("SET NAMES 'utf8'");
    $query = "SELECT  `component_name` FROM  `{$tabname}s` WHERE  `{$tabname}_name` =  '$row_name'";
    /* Выполняем запрос. Если произойдет ошибка - вывести ее. */
    $db_components = $mysqli->query($query) or die($query);
    $rows_counter = 0;
    while (($db_element_component = $db_components->fetch_assoc()) != false)
    {
        $rows_counter++;
    }
    return $rows_counter;
}



// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
//
//                        КОНЕЦ БЛОКА С ФУНКЦИЯМИ
//
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
?>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>




<?php

// Подключаемся к БД
$mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
// Выбираем кодовую страницу БД
$mysqli->query("SET NAMES 'utf8'");




// Удаление данных из таблицы recipеs
if(isset($_GET['del']))
{
    $del = $_GET['del'];
    rowdelete($del,$tabname);
}

// и $name для отображения в поле Название продукта
if (isset($_GET['edit_name'])) {$name = $edit_name = $_GET['edit_name'];}
else if (isset($_POST['edit_name'])) {$name = $edit_name = $_POST['edit_name'];}
else {$name = $edit_name = -1;}

// и $add_name для внесения в поле Название продукта
if (isset($_POST['add_name'])) {$add_name = $_POST['add_name'];}
else if (isset($_POST['add_name_edit'])) {$add_name = $_POST['add_name_edit'];}
else if (isset($_POST['add_name_mistake'])) {$add_name = $_POST['add_name_mistake'];}
else {$add_name = -1;}

// Проверка на уникальность название. Название должно быть уникальным.
// Берём то название, что хотим добавить и сравниваем с теми, что есть в базе.
// Если случается совпадение - перезагружаем форму с ошибкой на поле названия
// и выводом алерта с сообщением об ошибке
$i = 0;
$query = "SELECT `{$tabname}_name` FROM `{$tabname}s` ORDER BY {$tabname}_name";
$db_names = $mysqli->query($query) or die($query);

//    echo "<h3>Проверка на уникальность названия $add_name </h3><br>";
while (($db_item_names = $db_names->fetch_assoc()) != false) {

    if ((($_POST['add_name'] == $db_item_names[$tabname.'_name']) ||
            ($_POST['add_name_edit'] == $db_item_names[$tabname.'_name']) ||
            ($_POST['add_name_mistake'] == $db_item_names[$tabname.'_name']))
        &&
        ($add_name !== $edit_name)
        &&
        ($add_name !== '')
        &&
        ($add_name !== -1)
    )
    {
        $error = 1;
        $dubl = 1;
        $reason = $reason . 'Название продукта уже используется!\u000A';
        break;
    }
}

//                           Выбор режима работы ФОНА формы!
//               Варианты: серый фон - show_manag, желтый фон - shoe_edit
//                          ОШИБКА - РЕДАКТИРОВАНИЕ - ПРОСМОТР
if ($error == 1) {$showtype = 'show_mistake';}
else  if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow') {$showtype = 'show_edit';}
else  if ($_GET['showtype'] == 'show_manag' || $_POST['showtype'] == 'show_manag') {$showtype = 'show_manag';}
else {$showtype = 'show_no';}


//                           Выбор режима работы ПОЛЕЙ формы!
//   Варианты: красные и серые поля - event_mistake, желтые поля - event_edit, серые поля - event_first
//                          ОШИБКА - РЕДАКТИРОВАНИЕ - ПРОСМОТР
if ($error == 1) {$event = 'event_mistake';}
else if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow') {$event = 'event_edit';}
else {$event = 'event_first';}


//       Добавление данных в рабочую таблицу
if ($_POST['actiontype'] == 'add' || $_POST['actiontype'] == 'edit') {

//                         Начало блока
//                ЗАПОЛНЕНИЕ И РЕДАКТИРОВАНИЕ БД


// Если на предыдущем шаге выявили ошибки, в нашем случае - это пустые (не заполненные) поля строк
// В строке все поля, кроме комментария обязательные для заполнения, если заполнена хотябы одна ячейка


    $product_name = $_POST['add_name'];
    $unit_id = $_POST['unit_id'];
    $price_online = $_POST['price_online'];
    $protein = $_POST['protein'];
    $fat = $_POST['fat'];
    $carbohydrate = $_POST['carbohydrate'];
    $energy = $_POST['energy'];
    $store_min = $_POST['store_min'];
    $store_max = $_POST['store_max'];
    $store_online = $_POST['store_online'];


    if ($event == 'event_mistake')
    {
        echo "<script>alert('$reason');</script>";
    }


// Действие по редактированию через UPDATE
    else if ($_POST['actiontype'] == 'edit') {

        if ($diagnostics_event == 'on') {
            //     Диагностика данных, которые мы вносим!
            echo '
                <div class="diagnostika-2">
                <h2>Hi EDITOR!</h2>
                Редактирум: <span style="color: red;">'.$edit_name.'</span><br>
                Новое имя: <span style="color: red;">'.$add_name.'</span><br>
                
                Ед.измерения: <span style="color: red;">'.$unit_id.'</span><br><br>
                Цена онлайн: <span style="color: red;">' . $price_online . '</span> <b>||</b>
                Белок: <span style="color: red;">' . $protein . '</span> <b>||</b>
                Жир: <span style="color: red;">' . $fat . '</span> <b>||</b>
                Углеводы: <span style="color: red;">' . $carbohydrate . '</span><br><br>
                Энерг.ценность: <span style="color: red;">' . $energy . '</span> <b>||</b>
                Склад МИН: <span style="color: red;">' . $store_min . '</span> <b>||</b>
                Склад МАКС: <span style="color: red;">' . $store_max . '</span> <b>||</b>
                Склад сейчас: <span style="color: red;">' . $store_online . '</span><br><br>
                </div>
                ';
        }
        
        $query = "
            UPDATE `{$tabname}s`
            SET                              
                `{$tabname}_name` = '$add_name',
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
            WHERE  
            `{$tabname}_name` = '$edit_name'";
        /* Выполняем запрос. Если произойдет ошибка - вывести ее. */
        $mysqli->query($query) or die($query);
        }

// Добаление данных в Базу Данных
// Работает хорошо
    else if($_POST['actiontype'] == 'add') {

        if ($diagnostics_event == 'on') {
        //     Диагностика данных, которые мы вносим!
            echo '
                <div class="diagnostika-2">
                <h2>Hi NEW ITEM!</h2>
                Вносим: <span style="color: red;">'.$product_name.'</span><br>
                Ед.измерения: <span style="color: red;">'.$unit_id.'</span><br><br>
                Цена онлайн: <span style="color: red;">' . $price_online . '</span> <b>||</b>
                Белок: <span style="color: red;">' . $protein . '</span> <b>||</b>
                Жир: <span style="color: red;">' . $fat . '</span> <b>||</b>
                Углеводы: <span style="color: red;">' . $carbohydrate . '</span><br><br>
                Энерг.ценность: <span style="color: red;">' . $energy . '</span> <b>||</b>
                Склад МИН: <span style="color: red;">' . $store_min . '</span> <b>||</b>
                Склад МАКС: <span style="color: red;">' . $store_max . '</span> <b>||</b>
                Склад сейчас: <span style="color: red;">' . $store_online . '</span><br><br>
                </div>
                ';
        }



        $query = "INSERT INTO `products`
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
                        ";
        /* Выполняем запрос. Если произойдет ошибка - вывести ее. */
        $mysqli->query($query) or die($query);
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
            <form action="#" method="post">
                <button type="submit" name="showtype" value="show" class="btn btn-info">Склад</button>
                <button type="submit" name="showtype" value="shop" class="btn btn-outline-success">Купить</button>
                <button type="submit" name="showtype" value="trash" class="btn btn-outline-danger">Списать</button>
            </form>

            <br>








            <?php


            if ($diagnostics_var == 'on') {
// Данные с диагностикой. Отображаются в правом верхнем углу.
                echo '<div class="diagnostika-1">';
                echo '$event (строки) = <span style="color: red;">' . $event . '</span><br>';
                echo '$showtype (форма) = <span style="color: red;">' . $showtype . '</span><br>';
                echo '$name = <span style="color: red;">' . $name . '</span><br>';
                echo '$add_name = <span style="color: red;">' . $add_name . '</span><br>';
                echo '$add_name_edit = <span style="color: red;">' . $add_name_edit . '</span><br>';
                echo '$edit_name = <span style="color: red;">' . $edit_name . '</span><br>';
                echo '$tabname = <span style="color: red;">' . $tabname . '</span><br>';
                echo '$num_rows = <span style="color: red;">' . $num_rows . '</span><br>';

                echo '<br>';
                echo '$_POST[add_name_edit] = <span style="color: red;">' . $_POST[add_name_edit] . '</span><br>';
                echo '$_POST[showtype] = <span style="color: red;">' . $_POST[showtype] . '</span><br>';
                echo '$_POST[actiontype] = <span style="color: red;">' . $_POST[actiontype] . '</span><br>';
                // Дублированная строка. Выше уже выводим переменную $num_rows
                echo '$_POST[num_rows] = <span style="color: red;">' . $_POST[num_rows] . '</span><br>';
                echo '</div>';
            }




            // Строим форму со строками на количество которых влияет переменная $num_rows
            //             и таблицу с данными для редактирвоания

            if (isset($_POST['passforedit']) && $password !== $_POST['passforedit']) {
                echo "<script>alert('Не верный пароль для редактирования!');</script>";
                $showtype = 'show_no';
            }

            if ($showtype !== 'show_no' || isset($_GET['del']) || isset($_GET['edit_name']))
            {

            // ФОРМА работы с данными
            // Заголовок поля формы добавления и редактирования данных

                if ($showtype == 'show_edit')
                {
                    $query_unit = "SELECT * FROM `units` ORDER BY unit_name";
                    $query_prod = "SELECT * FROM `products` ORDER BY product_name";
                    echo "
                    <h4>Редактирование сырьевой позиции \"$name\"</h4>
                        <div class='editform'>
                        <form action='".$urlform."' class='form-horizontal' method='post'>
                            <div class='container'>
                                <div class='row'>
                                    <div class='col-xs-6'>
                                        <div class='form-group has-warning'>
                                            <input type='text' value='".$name."' class='col-xs-3 form-control form-control-warning' id='add_name_edit' name='add_name_edit' required>
                                        </div>
                                    </div>
                                    <div class='col-xs-2'>
                                        <div class='form-group has-warning'>
                                            <select class='form-control form-control-warning' id='unit_id' name='unit_id'  required>";


                    // Создаём выборку единиц измерения
                    $editquery = $mysqli->query($query_prod) or die($query_prod);

                    while (($editrr = $editquery->fetch_assoc()) != false)
                    {
                        if ($edit_name == $editrr['product_name'])
                        {
                            $editunit_id = $editrr['unit_id'];
                        }
                    };

                    $ddquery = $mysqli->query($query_unit) or die($query_unit);
                    while (($dropd = $ddquery->fetch_assoc()) != false)
                    {
                        if ($editunit_id == $dropd['unit_id'])
                        {
                            echo "<option value='" . $dropd['unit_id'] . "'>" . $dropd['unit_name'] . "</option>";
                        }
                    };
                    $ddquery = $mysqli->query($query_unit) or die($query_unit);

                    while (($dropd = $ddquery->fetch_assoc()) != false) {
                        if ($editunit_id !== $dropd['unit_id'])
                        {
                            echo "<option value='" . $dropd['unit_id'] . "'>" . $dropd['unit_name'] . "</option>";
                        }
                    };

                                                echo "
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col-xs-4'>
                                        <div class='input-group form-group has-warning'>";

                                            $editquery = $mysqli->query($query_prod) or die($query_prod);
                                            while (($editrr = $editquery->fetch_assoc()) != false)
                                            {
                                                if ($edit_name == $editrr['product_name'])
                                                {
                                                    echo "<input type='text' value='".$editrr['price_online']."' class='col-xs-3 form-control form-control-warning' id='price_online' name='price_online' required>";
                                                }
                                            };
                                            echo "
                                        <span class='input-group-addon'>руб.</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class='form-group row'>
                                    <div class='col-xs-3'>
                                        <div class='form-group has-warning'>";

                    $query = "SELECT * FROM `products` ORDER BY product_name";
                    $editquery = $mysqli->query($query) or die($query);
                                            while (($editrr = $editquery->fetch_assoc()) != false)
                                            {
                                                if ($edit_name == $editrr['product_name'])
                                                {
                                                    echo "<input type='text' value='".$editrr['protein']."' class='col-xs-3 form-control form-control-warning' id='protein' name='protein' required>";
                                                }
                                            };
                                            echo "
                                        </div>
                                    </div>
                                    <div class='col-xs-3'>
                                        <div class='form-group has-warning'>";

                    $query = "SELECT * FROM `products` ORDER BY product_name";
                    $editquery = $mysqli->query($query) or die($query);
                                            while (($editrr = $editquery->fetch_assoc()) != false)
                                            {
                                                if ($edit_name == $editrr['product_name'])
                                                {
                                                    echo "<input type='text' value='".$editrr['fat']."' class='col-xs-3 form-control form-control-warning' id='fat' name='fat' required>";
                                                }
                                            };
                                            echo "
                                        </div>
                                    </div>
                                    <div class='col-xs-3'>
                                        <div class='form-group has-warning'>";

                    $query = "SELECT * FROM `products` ORDER BY product_name";
                    $editquery = $mysqli->query($query) or die($query);
                                            while (($editrr = $editquery->fetch_assoc()) != false)
                                            {
                                                if ($edit_name == $editrr['product_name'])
                                                {
                                                    echo "<input type='text' value='".$editrr['carbohydrate']."' class='col-xs-3 form-control form-control-warning' id='carbohydrate' name='carbohydrate' required>";
                                                }
                                            };
                                            echo "
                                        </div>
                                    </div>
                                    <div class='col-xs-3'>
                                        <div class='form-group has-warning'>";

                    $query = "SELECT * FROM `products` ORDER BY product_name";
                    $editquery = $mysqli->query($query) or die($query);
                                            while (($editrr = $editquery->fetch_assoc()) != false)
                                            {
                                                if ($edit_name == $editrr['product_name'])
                                                {
                                                    echo "<input type='text' value='".$editrr['energy']."' class='col-xs-3 form-control form-control-warning' id='energy' name='energy' required>";
                                                }
                                            };
                                            echo "
                                        </div>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <div class='col-xs-3'>
                                        <div class='form-group has-warning'>";

                    $query = "SELECT * FROM `products` ORDER BY product_name";
                    $editquery = $mysqli->query($query) or die($query);
                                            while (($editrr = $editquery->fetch_assoc()) != false)
                                            {
                                                if ($edit_name == $editrr['product_name'])
                                                {
                                                    echo "<input type='text' value='".$editrr['store_min']."' class='col-xs-3 form-control form-control-warning' id='store_min' name='store_min' required>";
                                                }
                                            };
                                            echo "
                                        </div>
                                    </div>
                                    <div class='col-xs-3'>
                                        <div class='form-group has-warning'>";

                    $query = "SELECT * FROM `products` ORDER BY product_name";
                    $editquery = $mysqli->query($query) or die($query);
                                            while (($editrr = $editquery->fetch_assoc()) != false)
                                            {
                                                if ($edit_name == $editrr['product_name'])
                                                {
                                                    echo "<input type='text' value='".$editrr['store_online']."' class='col-xs-3 form-control form-control-warning' id='store_online' name='store_online' required>";
                                                }
                                            };
                                            echo "
                                        </div>
                                    </div>
                                    <div class='col-xs-3'>
                                        <div class='form-group has-warning'>";

                    $query = "SELECT * FROM `products` ORDER BY product_name";
                    $editquery = $mysqli->query($query) or die($query);
                                            while (($editrr = $editquery->fetch_assoc()) != false)
                                            {
                                                if ($edit_name == $editrr['product_name'])
                                                {
                                                    echo "<input type='text' value='".$editrr['store_max']."' class='col-xs-3 form-control form-control-warning' id='store_max' name='store_max' required>";
                                                }
                                            };
                                            echo "
                                        </div>
                                    </div>
                                    <div class='col-xs-3'>
                                        <input type='hidden' name='edit_name' value='".$name."'>
                                        <input type='hidden' name='showtype' value='show_manag'>
                                        <input type='hidden' name='actiontype' value='edit'>
                                        <button type='submit' name='edititem' class='btn btn-outline-warning pull-right'>Внести изменение</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    ";
                }


                else if ($showtype == 'show_mistake')
                {
                    $reason = trim($reason, '\u000A');
                    echo "
                    <h4>Ошибка: <span style='color: red;'>$reason</span></h4>
                        <div class='mistakeform'>
                        <form action='".$urlform."' class='form-horizontal' method='post'>
                            <div class='container'>
                                <div class='form-group row'>
                                    <div class='col-xs-6'>
                                        <div class='form-group has-danger'>
                                            <input type='text' value='".$name."' class='col-xs-3 form-control form-control-danger' id='add_name_mistake' name='add_name_mistake' required>
                                        </div>
                                    </div>
                                    <div class='col-xs-2'>
                                        <div class='form-group has-danger'>
                                            <select class='form-control form-control-danger' id='unit_id' name='unit_id'  required>";
                                                // Создаём выборку единиц измерения
                                                $query = "SELECT * FROM `units` ORDER BY unit_name";
                                                $ddquery = $mysqli->query($query) or die($query);
                                                // Выбираем выбранную единицу измерения
                                                while (($dropd = $ddquery->fetch_assoc()) != false)
                                                {
                                                    if ($_POST['unit_id'] == $dropd['unit_id'])
                                                    {
                                                        echo "<option value='" . $dropd['unit_id'] . "'>" . $dropd['unit_name'] . "</option>";
                                                    }
                                                };
                                                // Выводим остальные
                                                while (($dropd = $ddquery->fetch_assoc()) != false) {
                                                    if ($_POST['unit_id'] !== $dropd['unit_id'])
                                                    {
                                                        echo "<option value='" . $dropd['unit_id'] . "'>" . $dropd['unit_name'] . "</option>";
                                                    }
                                                };

                                                echo "
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col-xs-4'>
                                        <div class='input-group form-group has-danger'>";

                    $query = "SELECT * FROM `products` ORDER BY product_name";
                    $editquery = $mysqli->query($query) or die($query);
                                            $query = "SELECT * FROM `products` ORDER BY product_name";
                                            $editquery = $mysqli->query($query) or die($query);
                                            while (($editrr = $editquery->fetch_assoc()) != false)
                                            {
                                                if ($edit_name == $editrr['product_name'])
                                                {
                                                    echo "<input type='text' value='".$editrr['price_online']."' class='col-xs-3 form-control form-control-danger' id='price_online' name='price_online' required>";
                                                }
                                            };
                                            echo "
                                        <span class='input-group-addon'>руб.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <div class='col-xs-3'>
                                        <div class='form-group has-danger'>";

                    $query = "SELECT * FROM `products` ORDER BY product_name";
                    $editquery = $mysqli->query($query) or die($query);
                                            while (($editrr = $editquery->fetch_assoc()) != false)
                                            {
                                                if ($edit_name == $editrr['product_name'])
                                                {
                                                    echo "<input type='text' value='".$editrr['protein']."' class='col-xs-3 form-control form-control-danger' id='protein' name='protein' required>";
                                                }
                                            };
                                            echo "
                                        </div>
                                    </div>
                                    <div class='col-xs-3'>
                                        <div class='form-group has-danger'>";

                    $query = "SELECT * FROM `products` ORDER BY product_name";
                    $editquery = $mysqli->query($query) or die($query);
                                            while (($editrr = $editquery->fetch_assoc()) != false)
                                            {
                                                if ($edit_name == $editrr['product_name'])
                                                {
                                                    echo "<input type='text' value='".$editrr['fat']."' class='col-xs-3 form-control form-control-danger' id='fat' name='fat' required>";
                                                }
                                            };
                                            echo "
                                        </div>
                                    </div>
                                    <div class='col-xs-3'>
                                        <div class='form-group has-danger'>";

                    $query = "SELECT * FROM `products` ORDER BY product_name";
                    $editquery = $mysqli->query($query) or die($query);
                                            while (($editrr = $editquery->fetch_assoc()) != false)
                                            {
                                                if ($edit_name == $editrr['product_name'])
                                                {
                                                    echo "<input type='text' value='".$editrr['carbohydrate']."' class='col-xs-3 form-control form-control-danger' id='carbohydrate' name='carbohydrate' required>";
                                                }
                                            };
                                            echo "
                                        </div>
                                    </div>
                                    <div class='col-xs-3'>
                                        <div class='form-group has-danger'>";

                    $query = "SELECT * FROM `products` ORDER BY product_name";
                    $editquery = $mysqli->query($query) or die($query);
                                            while (($editrr = $editquery->fetch_assoc()) != false)
                                            {
                                                if ($edit_name == $editrr['product_name'])
                                                {
                                                    echo "<input type='text' value='".$editrr['energy']."' class='col-xs-3 form-control form-control-danger' id='energy' name='energy' required>";
                                                }
                                            };
                                            echo "
                                        </div>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <div class='col-xs-3'>
                                        <div class='form-group has-danger'>";

                    $query = "SELECT * FROM `products` ORDER BY product_name";
                    $editquery = $mysqli->query($query) or die($query);
                                            while (($editrr = $editquery->fetch_assoc()) != false)
                                            {
                                                if ($edit_name == $editrr['product_name'])
                                                {
                                                    echo "<input type='text' value='".$editrr['store_min']."' class='col-xs-3 form-control form-control-danger' id='store_min' name='store_min' required>";
                                                }
                                            };
                                            echo "
                                        </div>
                                    </div>
                                    <div class='col-xs-3'>
                                        <div class='form-group has-danger'>";

                    $query = "SELECT * FROM `products` ORDER BY product_name";
                    $editquery = $mysqli->query($query) or die($query);
                                            while (($editrr = $editquery->fetch_assoc()) != false)
                                            {
                                                if ($edit_name == $editrr['product_name'])
                                                {
                                                    echo "<input type='text' value='".$editrr['store_online']."' class='col-xs-3 form-control form-control-danger' id='store_online' name='store_online' required>";
                                                }
                                            };
                                            echo "
                                        </div>
                                    </div>
                                    <div class='col-xs-3'>
                                        <div class='form-group has-danger'>";

                    $query = "SELECT * FROM `products` ORDER BY product_name";
                    $editquery = $mysqli->query($query) or die($query);
                                            while (($editrr = $editquery->fetch_assoc()) != false)
                                            {
                                                if ($edit_name == $editrr['product_name'])
                                                {
                                                    echo "<input type='text' value='".$editrr['store_max']."' class='col-xs-3 form-control form-control-danger' id='store_max' name='store_max' required>";
                                                }
                                            };
                                            echo "
                                        </div>
                                    </div>
                                    <div class='col-xs-3'>
                                        <input type='hidden' name='edit_name' value='".$name."'>
                                        <input type='hidden' name='showtype' value='show_manag'>
                                        <input type='hidden' name='actiontype' value='edit'>
                                        <button type='submit' name='edititem' class='btn btn-outline-warning pull-right'>Исправить данные</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    
                    
                    ";
                }
                

                else if ($showtype == 'show_manag' || isset($_GET['del']))
                {
                    echo "
                    <h4>Добавление нового продукта</h4>
                        <div class='addform'>
                        <form action='".$urlform."' class='form-horizontal' method='post'>
                            <div class='container'>
                                <div class='row'>
                                    <div class='col-xs-6'>
                                        <div class='form-group'>
                                            <input type='text' placeholder='Наименование' class='col-xs-3 form-control' id='add_name' name='add_name' required>
                                        </div>
                                    </div>
                                    <div class='col-xs-2'>
                                        <div class='form-group'>
                                            <select class='form-control form-control' id='unit_id' name='unit_id'  required>";
                                                // Создаём выборку единиц измерения
                                                $query = "SELECT * FROM `units` ORDER BY unit_name";
                                                $ddquery = $mysqli->query($query) or die($query);
                                                while (($dropd = $ddquery->fetch_assoc()) != false) {
                                                    echo "<option value='" . $dropd['unit_id'] . "'>" . $dropd['unit_name'] . "</option>";
                                                };

                                                echo "
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col-xs-4'>
                                        <div class='input-group form-group'>
                                            <input type='number' min='0.00' max='5000.00' step='0.01' size='8' placeholder='Цена' class='col-xs-3 form-control' id='price_online' name='price_online' required>
                                            <span class='input-group-addon'>руб.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <div class='col-xs-3'>
                                        <div class='form-group'>
                                        <input type='number' min='0.000' max='100.000' step='0.001' size='8' placeholder='Белки' class='col-xs-3 form-control' id='protein' name='protein' required>
                                        </div>
                                    </div>
                                    <div class='col-xs-3'>
                                        <div class='form-group'>
                                            <input type='number' min='0.000' max='100.000' step='0.001' size='8' placeholder='Жиры' class='col-xs-3 form-control' id='fat' name='fat' required>
                                        </div>
                                    </div>
                                    <div class='col-xs-3'>
                                        <div class='form-group'>
                                            <input type='number' min='0.000' max='100.000' step='0.001' size='8' placeholder='Углеводы' class='col-xs-3 form-control' id='carbohydrate' name='carbohydrate' required>
                                        </div>
                                    </div>
                                    <div class='col-xs-3'>
                                        <div class='form-group'>
                                            <input type='number' min='0.00' max='5000.00' step='0.01' size='8' placeholder='Эн.ценность' class='col-xs-3 form-control' id='energy' name='energy' required>
                                        </div>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <div class='col-xs-3'>
                                        <div class='form-group'>
                                            <input type='number' min='0.000' max='50.000' step='0.001' size='8' placeholder='Мин.склад' class='col-xs-3 form-control' id='store_min' name='store_min' required>
                                        </div>
                                    </div>
                                    <div class='col-xs-3'>
                                        <div class='form-group'>
                                            <input type='number' min='0.000' max='50.000' step='0.001' size='8' placeholder='Склад онлайн' class='col-xs-3 form-control' id='store_online' name='store_online' required>
                                        </div>
                                    </div>
                                    <div class='col-xs-3'>
                                        <div class='form-group'>
                                            <input type='number' min='0.000' max='50.000' step='0.001' size='8' placeholder='Макс.склад' class='col-xs-3 form-control' id='store_max' name='store_max' required>
                                        </div>
                                    </div>
                                    <div class='col-xs-3'>
                                        <input type='hidden' name='showtype' value='show_manag'>
                                        <input type='hidden' name='actiontype' value='add'>
                                        <button type='submit' name='addnewitem' class='btn btn-outline-primary pull-right'>Добавить продукт</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                
                    ";
                }



            echo "
                <br>
                <table class='table table-hover' id='products_tab'>
                    <thead>
                    <tr>
                        <th>№<br>п/п</th>
                        <th>Наименование</th>
                        <th>Ед.<br>изм.</th>
                        <th class='td-right'>Прежд.<br>Цена</th>
                        <th class='td-right'>Цена<br>онлайн</th>
                        <th class='td-right'>Ср.<br>цена</th>
                        <th class='td-right'>Откл.</th>
                        <th class='td-right'>Белки</th>
                        <th class='td-right'>Жиры</th>
                        <th class='td-right'>Угл.</th>
                        <th class='td-right'>Эн.<br>ценн.</th>
                        <th class='td-right'>Мин.<br>склад</th>
                        <th class='td-right'>Склад<br>онлайн</th>
                        <th class='td-right'>Макс.<br>склад</th>
                        <th class='td-right'>Редакт.</th>
                    </tr>
                    </thead>
                    <tbody>                    
                ";


                $edbutt = 1;
                // Создаём массив для работы с ним
                $query = "SELECT * FROM `{$tabname}s` ORDER BY {$tabname}_name";
                $items_result_set = $mysqli->query($query) or die($query);
                // Наполняем таблицу строками
                echo showTable ($items_result_set,$tabname,$nutr_val,$edbutt,$diagnostics_tab);


                echo "
                    </tbody>
                </table>
                
                <div class='pull-right' style='color: #aaa;'>Пищевая и энергетическая ценность в таблице указана на 100 грамм!</div>
                <br>";

                
                
                    
            
            
// Режим просмотра таблицы
            } else {



            echo "
            <table class='table table-hover'>
                <thead>
                <tr>
                    <th>№ п/п</th>
                    <th>Наименование</th>
                    <th>Ед.изм.</th>
                    <th class='td-right'>Преждняя цена</th>
                    <th class='td-right'>Цена онлайн</th>
                    <th class='td-right'>Отклонение</th>
                    <th class='td-right'>Склад онлайн</th>
                </tr>
                </thead>

                <tbody>

                ";

                $edbutt = 0;
                // Создаём массив для работы с ним
                $query = "SELECT * FROM `{$tabname}s` ORDER BY {$tabname}_name";
                $items_result_set = $mysqli->query($query) or die($query);
                // Наполняем таблицу строками
                echo showTable ($items_result_set,$tabname,$nutr_val,$edbutt,$diagnostics_tab);


                echo "
                </tbody>
            </table>
		
	    <br>
            <form action='".$urlform."' method='post' class='form-inline'>
                <input type='password' placeholder='Пароль для редактирования' class='form-control' id='passforedit' name='passforedit' size='20'>
				<input type='hidden' name='showtype' value='show_manag'>
                <button type='submit' class='btn btn-outline-success'>Управлять данными</button>
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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>
<script>
    $("form").submit(function(e) {

        var ref = $(this).find("[required]");

        $(ref).each(function(){
            if ( $(this).val() == '' )
            {
                alert("Все поля должны быть заполнены.");

                $(this).focus();

                e.preventDefault();
                return false;
            }
        });  return true;
    });
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