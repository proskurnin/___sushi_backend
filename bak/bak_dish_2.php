<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Полуфабрикаты - Рецепты - Блюда - Сеты</title>

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


// Установка name для редактирования
if (isset($_GET['edit_name']))
{
    $edit_name = $_GET['edit_name'];
}
else if (isset($_POST['edit_name']))
{
    $edit_name = $_POST['edit_name'];
}
else
{
    $edit_name = -1;
}


// Удаление данных из таблицы reciepts
if(isset($_GET['del']))
{
    $del = $_GET['del'];
    $query = "DELETE FROM  `recipes` WHERE  `recipe_name` = $del";
    /* Выполняем запрос. Если произойдет ошибка - вывести ее. */
    $mysqli->query($query) or die($query);
}


// Строим строки с полями формы
function rowform ($i,$event,$edit_name) {
    if ($event == 'firstlook') {

        $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
        $mysqli->query("SET NAMES 'utf8'");
        $options_products = '';
        $selproduct = $mysqli->query("SELECT * FROM `products`") or die();
        while (($optproduct = $selproduct->fetch_assoc()) != false)
        {
            $options_products = $options_products."<option value='product_".$optproduct['product_id']."'>".$optproduct['product_name']."</option>";
        }
        $options_semis = '';
        $selsemis = $mysqli->query("SELECT * FROM `semis`") or die();
        while (($optsemis = $selsemis->fetch_assoc()) != false)
        {
            $options_semis = $options_semis."<option value='semi_".$optsemis['semi_id']."'>".$optsemis['semi_name']."</option>";
        }
        $mysqli->close();


        $rowOfComponent = "
        
        <div class='row'>
        
        <!-- Компонент рецепта -->
            <div class='col-xs-4'>
                <div class='form-group'>
                <select class='form-control' id='component_id_{$i}' name='component_id_{$i}'>
                        <option value='0'>Выберите компонент №{$i}</option>
                        <optgroup label='Сырьё и упаковка'>
                            {$options_products}
                        </optgroup>
                        <optgroup label='Полуфабрикаты'>
                            {$options_semis}
                        </optgroup>
                </select>
                </div>
            </div>


        <!-- Количество компонента БРУТТО -->
            <div class='col-xs-2'>
                <div class='form-group'>              
                    <input type='text' placeholder='Брутто' class='col-xs-2 form-control' id='gross_{$i}' name='gross_{$i}'>
                </div>
            </div>


        <!-- Количество компонента НЕТТО -->
            <div class='col-xs-2'>
                <div class='form-group'>
                    <input type='text' placeholder='Нетто' class='col-xs-2 form-control' id='net_{$i}' name='net_{$i}'>
                </div>
            </div>


        <!-- Комментарий к компоненту -->
            <div class='col-xs-3'>
                <div class='form-group'>
                    <input type='text' placeholder='Комментарий' class='col-xs-4 form-control' id='component_comment_{$i}' name='component_comment_{$i}'>
                </div>
            </div>
        
        
        <!-- Управляющие конструкции -->
            <div class='col-xs-1'>
                <div class='form-group' style='vertical-align: middle;'>
                    <i class='fa fa-plus' aria-hidden='true' style='color: green;'></i>
                    &nbsp;&nbsp;
                    <i class='fa fa-minus' aria-hidden='true' style='color: red;'></i>
                
                </div>
            </div>
        </div>
        ";
    }
    if ($event == 'mistake') {


//       ДИАГНОСТИКА
//
//        echo '$i = '.$i.'<br>';
//        echo 'Компонент: '.(!isset($_POST['component_id_'.$i]) xor $_POST['component_id_'.$i] == '0' xor $_POST['component_id_'.$i] == '');
//        echo ' - значение: '.$_POST['component_id_'.$i].'<br>';
//        echo 'Брутто: '.(!isset($_POST['gross_'.$i]) xor $_POST['gross_'.$i] == '0' xor $_POST['gross_'.$i] == '');
//        echo ' - значение: '.$_POST['gross_'.$i].'<br>';
//        echo 'Нетто: '.(!isset($_POST['net_'.$i]) xor $_POST['net_'.$i] == '0' xor $_POST['net_'.$i] == '');
//        echo ' - значение: '.$_POST['net_'.$i].'<br>';
//        echo 'Комментарий: '.(!isset($_POST['component_comment_'.$i]) xor $_POST['component_comment_'.$i] == '0' xor $_POST['component_comment_'.$i] == '');
//        echo ' - значение: '.$_POST['component_comment_'.$i].'<br>';
//        echo '<br>';
//        echo (
//            (!isset($_POST['component_id_'.$i]) xor $_POST['component_id_'.$i] == '0' xor $_POST['component_id_'.$i] == '') &&
//            (!isset($_POST['gross_'.$i]) xor $_POST['gross_'.$i] == '0' xor $_POST['gross_'.$i] == '') &&
//            (!isset($_POST['net_'.$i]) xor $_POST['net_'.$i] == '0' xor $_POST['net_'.$i] == '') &&
//            (!isset($_POST['component_comment_'.$i]) xor $_POST['component_comment_'.$i] == '0' xor $_POST['component_comment_'.$i] == '')
//        ).'<br>';
//
//      КОНЕЦ ДИАГНОСТИКИ



        if (
            (!isset($_POST['component_id_'.$i]) xor $_POST['component_id_'.$i] == '0' xor $_POST['component_id_'.$i] == '') &&
            (!isset($_POST['gross_'.$i]) xor $_POST['gross_'.$i] == '0' xor $_POST['gross_'.$i] == '') &&
            (!isset($_POST['net_'.$i]) xor $_POST['net_'.$i] == '0' xor $_POST['net_'.$i] == '') &&
            (!isset($_POST['component_comment_'.$i]) xor $_POST['component_comment_'.$i] == '0' xor $_POST['component_comment_'.$i] == '')
        )

        {} else {


            $component_id = $_POST['component_id_'.$i];
            $component_id = trim($component_id, 'product_id_');

            $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
            $mysqli->query("SET NAMES 'utf8'");
            $options_products = '';
            $selproduct = $mysqli->query("SELECT * FROM `products`") or die();
            while (($optproduct = $selproduct->fetch_assoc()) != false)
            {
                if ($component_id == $optproduct['product_id'])
                {
                    $select_option = $optproduct['product_name'];
                }
                $options_products = $options_products."<option value='product_".$optproduct['product_id']."'>".$optproduct['product_name']."</option>";
            }
            $options_semis = '';
            $selsemis = $mysqli->query("SELECT * FROM `semis`") or die();
            while (($optsemis = $selsemis->fetch_assoc()) != false)
            {
                $options_semis = $options_semis."<option value='semi_".$optsemis['semi_id']."'>".$optsemis['semi_name']."</option>";
            }
            $mysqli->close();



            $element_component = '';
            $element_gross = '';
            $element_net = '';
            $element_comment = '';


            // Формируем элемент КОМПОНЕНТ
            if ($_POST['component_id_'.$i] == '0' || $_POST['component_id_'.$i] == '') {
                $element_component = "
                <div class='col-xs-4'>
                    <div class='form-group has-danger'>
                    <select class='form-control form-control-dange' id='component_id_{$i}' name='component_id_{$i}'>
                        <option value='0'>Не указано!</option>
                        <optgroup label='Сырьё и упаковка'>
                            {$options_products}
                        </optgroup>
                        <optgroup label='Полуфабрикаты'>
                            {$options_semis}
                        </optgroup>
                    </select>
                    </div>
                </div>
                ";
            }
            else
            {
                $element_component = "
                <div class='col-xs-4'>
                    <div class='form-group has-success'>
                    <select class='form-control form-control-success' id='component_id_{$i}' name='component_id_{$i}'>
                        <option value='{$component_id}'>{$select_option}</option>
                        <optgroup label='Сырьё и упаковка'>
                            {$options_products}
                        </optgroup>
                        <optgroup label='Полуфабрикаты'>
                            {$options_semis}
                        </optgroup>
                    </select>
                    </div>
                </div>
                ";
            }

            // Формируем элемент БРУТТО
            if ($_POST['gross_'.$i] == '0' || $_POST['gross_'.$i] == '') {
                $element_gross = "
                <div class='col-xs-2'>
                    <div class='form-group has-danger'>
                        <div class='input-group'>
                            <input type='text' placeholder='Брутто' class='col-xs-3 form-control form-control-danger' id='gross_{$i}' name='gross_{$i}'>
                        </div>
                    </div>
                </div>
                ";
            }
            else
            {
                $element_gross = "
                <div class='col-xs-2'>
                    <div class='form-group has-success'>
                        <div class='input-group'>
                            <input type='text' value='".$_POST['gross_'.$i]."' class='col-xs-3 form-control form-control-success' id='gross_{$i}' name='gross_{$i}'>
                        </div>
                    </div>
                </div>
                ";
            }

            // Формируем элемент НЕТТО
            if ($_POST['net_'.$i] == '0' || $_POST['net_'.$i] == '') {
                $element_net = "
                <div class='col-xs-2'>
                    <div class='form-group has-danger'>
                        <div class='input-group'>
                            <input type='text' placeholder='Нетто' class='col-xs-3 form-control form-control-danger' id='net_{$i}' name='net_{$i}'>
                        </div>
                    </div>
                </div>
                ";
            }
            else
            {
                $element_net = "
                <div class='col-xs-2'>
                    <div class='form-group has-success'>
                        <div class='input-group'>
                            <input type='text' value='".$_POST['net_'.$i]."' class='col-xs-3 form-control form-control-success' id='net_{$i}' name='net_{$i}'>
                        </div>
                    </div>
                </div>
                ";
            }

            // Формируем элемент КОММЕНТАРИЙ
            if ($_POST['component_comment_'.$i] == '0' || $_POST['component_comment_'.$i] == '') {
                $element_comment = "
                <div class='col-xs-3'>
                    <div class='form-group'>
                        <div class='input-group'>
                            <input type='text' placeholder='Комментарий' class='col-xs-3 form-control' id='component_comment_{$i}' name='component_comment_{$i}'>
                        </div>
                    </div>
                </div>
                ";
            }
            else
            {
                $element_comment = "
                <div class='col-xs-3'>
                    <div class='form-group has-success'>
                        <div class='input-group'>
                            <input type='text' value='".$_POST['component_comment_'.$i]."' class='col-xs-3 form-control form-control-success' id='component_comment_{$i}' name='component_comment_{$i}'>            
                        </div>
                    </div>
                </div>
                ";
            }




            $rowOfComponent = "
            
            <div class='row'>
            
            <!-- Компонент рецепта -->
                {$element_component}
    
            <!-- Количество компонента БРУТТО -->
                {$element_gross}
    
    
            <!-- Количество компонента НЕТТО -->
                {$element_net}
    
    
            <!-- Комментарий к компоненту -->
                {$element_comment}
            
            <!-- Управляющие конструкции -->
                <div class='col-xs-1'>
                    <div class='form-group' style='vertical-align: middle;'>
                        <i class='fa fa-plus' aria-hidden='true' style='color: green;'></i>
                        &nbsp;&nbsp;
                        <i class='fa fa-minus' aria-hidden='true' style='color: red;'></i>
                    
                    </div>
                </div>
            </div>
            ";
        }
    }
    if ($event == 'editdoc') {

        $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
        $mysqli->query("SET NAMES 'utf8'");

        $db_components = $mysqli->query("SELECT  `product_id` FROM  `recipes` WHERE  `recipe_name` =  '$edit_name'") or die();
        while (($db_element_component = $db_components->fetch_assoc()) != false)
        {
            $element_component[] = array_shift($db_element_component);
        }
        $db_gross = $mysqli->query("SELECT  `product_gross` FROM  `recipes` WHERE  `recipe_name` =  '$edit_name'") or die();
        while (($db_element_gross = $db_gross->fetch_assoc()) != false)
        {
            $element_gross[] = array_shift($db_element_gross);
        }
        $db_net = $mysqli->query("SELECT  `product_net` FROM  `recipes` WHERE  `recipe_name` =  '$edit_name'") or die();
        while (($db_element_net = $db_net->fetch_assoc()) != false)
        {
            $element_net[] = array_shift($db_element_net);
        }
        $db_comment = $mysqli->query("SELECT  `component_comment` FROM  `recipes` WHERE  `recipe_name` =  '$edit_name'") or die();
        while (($db_element_comment = $db_comment->fetch_assoc()) != false)
        {
            $element_comment[] = array_shift($db_element_comment);
        }
        $j = $i - 1;


//    ДИАГНОСТИКА
//
//        echo 'шаг номер '.$i.'<br>';
//        echo '<b>$element_component['.$j.'] = '.$element_component[$j].'</b><br>';
//        echo '<b>$element_gross['.$j.'] = '.$element_gross[$j].'</b><br>';
//        echo '<b>$element_net['.$j.'] = '.$element_net[$j].'</b><br>';
//        echo '<b>$element_comment['.$j.'] = '.$element_comment[$j].'</b><br>';
//
//    КОНЕЦ ДИАГНОСТИКИ





        if (
            (!isset($_POST['component_id_'.$i]) xor $_POST['component_id_'.$i] == '0' xor $_POST['component_id_'.$i] == '') &&
            (!isset($_POST['gross_'.$i]) xor $_POST['gross_'.$i] == '0' xor $_POST['gross_'.$i] == '') &&
            (!isset($_POST['net_'.$i]) xor $_POST['net_'.$i] == '0' xor $_POST['net_'.$i] == '') &&
            (!isset($_POST['component_comment_'.$i]) xor $_POST['component_comment_'.$i] == '0' xor $_POST['component_comment_'.$i] == '')
        )

        {} else {

            $component_id = $element_component[$j];

            $options_products = '';
            $selproduct = $mysqli->query("SELECT * FROM `products`") or die();
            while (($optproduct = $selproduct->fetch_assoc()) != false)
            {
                if ($component_id == $optproduct['product_id'])
                {
                    $select_option = $optproduct['product_name'];
                }
                $options_products = $options_products."<option value='product_".$optproduct['product_id']."'>".$optproduct['product_name']."</option>";
            }
            $options_semis = '';
            $selsemis = $mysqli->query("SELECT * FROM `semis`") or die();
            while (($optsemis = $selsemis->fetch_assoc()) != false)
            {
                $options_semis = $options_semis."<option value='semi_".$optsemis['semi_id']."'>".$optsemis['semi_name']."</option>";
            }
            $mysqli->close();





            // Формируем элемент КОМПОНЕНТ
            if ($component_id == '0' || $component_id == '') {
                $element_component = "
                <div class='col-xs-4'>
                    <div class='form-group'>
                    <select class='form-control' id='component_id_{$i}' name='component_id_{$i}'>
                        <option value='0'>Выберите компонент {$i}</option>
                        <optgroup label='Сырьё и упаковка'>
                            {$options_products}
                        </optgroup>
                        <optgroup label='Полуфабрикаты'>
                            {$options_semis}
                        </optgroup>
                    </select>
                    </div>
                </div>
                ";
            }
            else
            {
                $element_component = "
                <div class='col-xs-4'>
                    <div class='form-group has-warning'>
                    <select class='form-control form-control-warning' id='component_id_{$i}' name='component_id_{$i}'>
                        <option value='{$component_id}'>{$select_option}</option>
                        <optgroup label='Сырьё и упаковка'>
                            {$options_products}
                        </optgroup>
                        <optgroup label='Полуфабрикаты'>
                            {$options_semis}
                        </optgroup>
                    </select>
                    </div>
                </div>
                ";
            }

            // Формируем элемент БРУТТО
            if ($element_gross[$j] == '0' || $element_gross[$j] == '') {
                $element_gross = "
                <div class='col-xs-2'>
                    <div class='form-group'>
                        <div class='input-group'>
                            <input type='text' placeholder='Брутто' class='col-xs-3 form-control' id='gross_{$i}' name='gross_{$i}'>
                        </div>
                    </div>
                </div>
                ";
            }
            else
            {
                $element_gross = "
                <div class='col-xs-2'>
                    <div class='form-group has-warning'>
                        <div class='input-group'>
                            <input type='text' value='".$element_gross[$j]."' class='col-xs-3 form-control form-control-warning' id='gross_{$i}' name='gross_{$i}'>
                        </div>
                    </div>
                </div>
                ";
            }

            // Формируем элемент НЕТТО
            if ($element_net[$j] == '0' || $element_net[$j] == '') {
                $element_net = "
                <div class='col-xs-2'>
                    <div class='form-group'>
                        <div class='input-group'>
                            <input type='text' placeholder='Нетто' class='col-xs-3 form-control' id='net_{$i}' name='net_{$i}'>
                        </div>
                    </div>
                </div>
                ";
            }
            else
            {
                $element_net = "
                <div class='col-xs-2'>
                    <div class='form-group has-warning'>
                        <div class='input-group'>
                            <input type='text' value='".$element_net[$j]."' class='col-xs-3 form-control form-control-warning' id='net_{$i}' name='net_{$i}'>
                        </div>
                    </div>
                </div>
                ";
            }

            // Формируем элемент КОММЕНТАРИЙ
            if ($element_comment[$j] == '0' || $element_comment[$j] == '') {
                $element_comment = "
                <div class='col-xs-3'>
                    <div class='form-group'>
                        <div class='input-group'>
                            <input type='text' placeholder='Комментарий' class='col-xs-3 form-control' id='component_comment_{$i}' name='component_comment_{$i}'>
                        </div>
                    </div>
                </div>
                ";
            }
            else
            {
                $element_comment = "
                <div class='col-xs-3'>
                    <div class='form-group has-warning'>
                        <div class='input-group'>
                            <input type='text' value='".$element_comment[$j]."' class='col-xs-3 form-control form-control-warning' id='component_comment_{$i}' name='component_comment_{$i}'>            
                        </div>
                    </div>
                </div>
                ";
            }




            $rowOfComponent = "
            
            <div class='row'>
            
            <!-- Компонент рецепта -->
                {$element_component}
    
            <!-- Количество компонента БРУТТО -->
                {$element_gross}
    
    
            <!-- Количество компонента НЕТТО -->
                {$element_net}
    
    
            <!-- Комментарий к компоненту -->
                {$element_comment}
            
            <!-- Управляющие конструкции -->
                <div class='col-xs-1'>
                    <div class='form-group' style='vertical-align: middle;'>
                        <i class='fa fa-plus' aria-hidden='true' style='color: green;'></i>
                        &nbsp;&nbsp;
                        <i class='fa fa-minus' aria-hidden='true' style='color: red;'></i>
                    
                    </div>
                </div>
            </div>
            ";
        }
    }

    return $rowOfComponent;
}


// Строим БОЛЬШУЮ таблицу для добавления, удаления и редактирования данных
//
//             НЕ ДЕЛАЛ !!!
//
function editTable ($result_set)
{

    $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
    $mysqli->query("SET NAMES 'utf8'");

    $counter = 0;
    $npp = 0;
    $recipe_name = '';
    $recipe_name_check = '';

    while (($row = $result_set->fetch_assoc()) != false) {
//        echo '<br>';
//        echo $recipe_name_check . " - - - - - - - - - ";
//        echo $row['recipe_name'] . "<br>";
        if ($recipe_name_check !== $row['recipe_name'])
        {
            if ($npp !== 0)
            {
                echo "<tr>";
                echo "<td>" . $npp . "</td>";
                echo "<td>" . $recipe_name . "</td>";
                echo "<td>" . $recipe_amount . "</td>";
                echo "<td>" . $recipe_cost . "</td>";
                echo "<td>" . $recipe_protein . "</td>";
                echo "<td>" . $recipe_fat . "</td>";
                echo "<td>" . $recipe_carbohydrate . "</td>";
                echo "<td>" . $recipe_energy . "</td>";
                echo "<td>
                    <a name='del' href=dish.php?del='".urlencode($recipe_name)."'>
                    <i class='fa fa-times' aria-hidden='true' style='color: red;'></i>
                    </a>
            
                    &nbsp;&nbsp;&nbsp;
            
                    <a name='edit' href=dish.php?editrow=editrow&edit_name='".urlencode($recipe_name)."'>
                    <i class='fa fa-pencil-square-o' aria-hidden='true' style='color: cornflowerblue;'></i>
                    </a>
                </td>
                </tr>";

            }
            $npp++;

            $recipe_amount = 0;
            $recipe_cost = 0;
            $recipe_protein = 0;
            $recipe_fat = 0;
            $recipe_carbohydrate = 0;
            $recipe_energy = 0;
        }

        $recipe_name = $row['recipe_name'];
        $recipe_name_check = $row['recipe_name'];

        foreach ($row as $k => $v) {
//            echo '$k ('.$k.') = '.($k == 'recipe_name').' ';
//            echo '$v = '.($v == $recipe_name).'<br>';
            if (($k == 'recipe_name') && ($v == $recipe_name)) {
                // НУЖНО ДОБАВИТЬ ПОЛУФАБРИКАТЫ
                $dbproduct = $mysqli->query("SELECT * FROM `products` WHERE  `product_id` = " . $row['product_id']) or die();
                $product = $dbproduct->fetch_assoc();

                $recipe_amount = $recipe_amount + ($row["product_net"]);

//                    echo $row['product_id'] . ": ";
//                    echo $recipe_cost . ' = ' . $recipe_cost . ' + (' . $row["product_gross"] . ' * ' . $product["price_online"] . ')<br>';
                $recipe_cost = $recipe_cost + ($row["product_gross"] * $product["price_online"]);
//                    echo "$$$ " . $recipe_cost . "<br>";

                $recipe_protein = $recipe_protein + ($row["product_net"] * $product["protein"]);
                $recipe_fat = $recipe_fat + ($row["product_net"] * $product["fat"]);
                $recipe_carbohydrate = $recipe_carbohydrate + ($row["product_net"] * $product["carbohydrate"]);
                $recipe_energy = $recipe_energy + ($row["product_net"] * $product["energy"]);
            }
        }
    }
    if ($npp !== 0)
    {
        echo "<tr>";
        echo "<td>" . $npp . "</td>";
        echo "<td>" . $recipe_name . "</td>";
        echo "<td>" . $recipe_amount . "</td>";
        echo "<td>" . $recipe_cost . "</td>";
        echo "<td>" . $recipe_protein . "</td>";
        echo "<td>" . $recipe_fat . "</td>";
        echo "<td>" . $recipe_carbohydrate . "</td>";
        echo "<td>" . $recipe_energy . "</td>";



        echo "<td>
        <a name='del' href=dish.php?del='".urlencode($recipe_name)."'>
        <i class='fa fa-times fa' aria-hidden='true' style='color: red;'></i>
        </a>

        &nbsp;&nbsp;&nbsp;

        <a name='edit' href='dish.php?editrow=editrow&edit_name=".urlencode($recipe_name)."'>
        <i class='fa fa-pencil-square-o fa' aria-hidden='true' style='color: cornflowerblue;'></i>
        </a>
        </td>
        </tr>";
    }

    $mysqli->close();
}

// Строим МАЛУЮ таблицу для просмотра
//
//             CДЕЛАЛ !!!
//
function showTable ($result_set)
{

    $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
    $mysqli->query("SET NAMES 'utf8'");

    $counter = 0;
    $npp = 0;
    $recipe_name = '';
    $recipe_name_check = '';

    while (($row = $result_set->fetch_assoc()) != false) {
//        echo '<br>';
//        echo $recipe_name_check . " - - - - - - - - - ";
//        echo $row['recipe_name'] . "<br>";
        if ($recipe_name_check !== $row['recipe_name'])
        {
            if ($npp !== 0)
            {
                echo "<tr>";
                echo "<td>" . $npp . "</td>";
                echo "<td>" . $recipe_name . "</td>";
                echo "<td>" . $recipe_amount . "</td>";
                echo "<td>" . $recipe_cost . "</td>";
                echo "<td>" . $recipe_protein . "</td>";
                echo "<td>" . $recipe_fat . "</td>";
                echo "<td>" . $recipe_carbohydrate . "</td>";
                echo "<td>" . $recipe_energy . "</td>";
                echo "</tr>";
            }
            $npp++;

            $recipe_amount = 0;
            $recipe_cost = 0;
            $recipe_protein = 0;
            $recipe_fat = 0;
            $recipe_carbohydrate = 0;
            $recipe_energy = 0;
        }

        $recipe_name = $row['recipe_name'];
        $recipe_name_check = $row['recipe_name'];

        foreach ($row as $k => $v) {
//            echo '$k ('.$k.') = '.($k == 'recipe_name').' ';
//            echo '$v = '.($v == $recipe_name).'<br>';
            if (($k == 'recipe_name') && ($v == $recipe_name)) {
                // НУЖНО ДОБАВИТЬ ПОЛУФАБРИКАТЫ
                $dbproduct = $mysqli->query("SELECT * FROM `products` WHERE  `product_id` = " . $row['product_id']) or die();
                $product = $dbproduct->fetch_assoc();

                $recipe_amount = $recipe_amount + ($row["product_net"]);

//                    echo $row['product_id'] . ": ";
//                    echo $recipe_cost . ' = ' . $recipe_cost . ' + (' . $row["product_gross"] . ' * ' . $product["price_online"] . ')<br>';
                $recipe_cost = $recipe_cost + ($row["product_gross"] * $product["price_online"]);
//                    echo "$$$ " . $recipe_cost . "<br>";

                $recipe_protein = $recipe_protein + ($row["product_net"] * $product["protein"]);
                $recipe_fat = $recipe_fat + ($row["product_net"] * $product["fat"]);
                $recipe_carbohydrate = $recipe_carbohydrate + ($row["product_net"] * $product["carbohydrate"]);
                $recipe_energy = $recipe_energy + ($row["product_net"] * $product["energy"]);
            }
        }
    }
    if ($npp !== 0)
    {
        echo "<tr>";
        echo "<td>" . $npp . "</td>";
        echo "<td>" . $recipe_name . "</td>";
        echo "<td>" . $recipe_amount . "</td>";
        echo "<td>" . $recipe_cost . "</td>";
        echo "<td>" . $recipe_protein . "</td>";
        echo "<td>" . $recipe_fat . "</td>";
        echo "<td>" . $recipe_carbohydrate . "</td>";
        echo "<td>" . $recipe_energy . "</td>";
        echo "</tr>";
    }

    $mysqli->close();
}




// Добавление данных в таблицу products
//
//          CДЕЛАЛ ДОБАВЛЕНИЕ !!!
//   НЕ СДЕЛАЛ ВООБЩЕ ПОЛУФАБРИКАТЫ !!!
//
//       НЕ СДЕЛАЛ РЕДАКТИРОВАНИЕ !!!
//
if ($_POST['add'] == 'submit' || $_POST['editrow'] == 'editrow')
{
    $recipe_name = $_POST['recipe_name'];
    $error = 0;

    if (!isset($_POST['recipe_name']) || $recipe_name == '')
    {
        $error = 1;
        $reason = $reason.'Не указано название рецепта!\u000A';
    }
    else
    {
        for ($i = 0; $i++ < 8;) {
            echo $_POST['component_id_'.$i];
            if (isset($_POST['component_id_'.$i]) && $_POST['component_id_'.$i] !== '0')
            {
                if (!isset($_POST['gross_'.$i]) || $_POST['gross_'.$i] == '0' || $_POST['gross_'.$i] == '')
                {
                    echo $_POST['component_id_'.$i];
                    $error = 1;
                    $reason = $reason.'<< Компон. >> Не указан вес Брутто! (шаг '.$i.')\u000A';
                }
                if (!isset($_POST['net_'.$i]) || $_POST['net_'.$i] == '0' || $_POST['net_'.$i] == '')
                {
                    echo $_POST['net_'.$i];
                    $error = 1;
                    $reason = $reason.'<< Компон. >> Не указан вес Нетто! (шаг '.$i.')\u000A';
                }
            }
            else if ($_POST['gross_'.$i] > 0)
            {
                if (!isset($_POST['component_id_'.$i]) || $_POST['component_id_'.$i] == '0' || $_POST['component_id_'.$i] == '')
                {
                    echo $_POST['component_id_'.$i];
                    $error = 1;
                    $reason = $reason.'<< Брутто >> Не указан Компонент! (шаг '.$i.')\u000A';
                }
                if (!isset($_POST['net_'.$i]) || $_POST['net_'.$i] == '0' || $_POST['net_'.$i] == '')
                {
                    echo $_POST['net_'.$i];
                    $error = 1;
                    $reason = $reason.'<< Брутто >> Не указан вес Нетто! (шаг '.$i.')\u000A';
                }
            }
            else if ($_POST['net_'.$i] > 0)
            {
                if (!isset($_POST['component_id_'.$i]) || $_POST['component_id_'.$i] == '0' || $_POST['component_id_'.$i] == '')
                {
                    echo $_POST['component_id_'.$i];
                    $error = 1;
                    $reason = $reason.'<< Нетто >> Не указан Компонент! (шаг '.$i.')\u000A';
                }
                if (!isset($_POST['gross_'.$i]) || $_POST['gross_'.$i] == '0' || $_POST['gross_'.$i] == '')
                {
                    echo $_POST['gross_'.$i];
                    $error = 1;
                    $reason = $reason.'<< Нетто >> Не указан вес Брутто! (шаг '.$i.')\u000A';
                }
            }
            else
            {
                if ($error == 0)
                {
                    $error = 0;
                    $reason = $reason.'Нет ошибок! (шаг '.$i.')\u000A';
                }
            }
        }
    }


    echo '$recipe_name = '.$recipe_name.'<br>';



    if ($error == 1)
    {
        echo "<script>alert('$reason');</script>";
    }
    else if ($_POST['editrow'] == 'editrow') {
//        echo "Hi EDITOR!";

        $del = $_GET['edit_name'];
        $query = "DELETE FROM  `recipes` WHERE  `recipe_name` = '".$del."'";
        /* Выполняем запрос. Если произойдет ошибка - вывести ее. */
        $mysqli->query($query) or die($query);

        for ($i = 0; $i++ < 8;) {
            $components[] = $_POST['component_id_'.$i];
            $gross[] = $_POST['gross_'.$i];
            $net[] = $_POST['net_'.$i];
            $comment[] = $_POST['component_comment_'.$i];
        }

        for ($i = 0; $i++ < 8;) {
            $j = $i - 1;

            $product_id = $components[$j];
            $product_id = trim($product_id, '$product_');
            $product_gross = $gross[$j];
            $product_net = $net[$j];
// ПОЛУФАБРИКАТЫ ДОБАВИТЬ ПОЗЖЕ !!! а пока пустое значение
            $semi_id = '0';
            $semi_gross = '0';
            $semi_net = '0';
// ПОЗЖЕ !!! а пока пустое значение
            $component_comment = $comment[$j];



//            echo $i.', ';
//            echo $product_id.', ';
//            echo $product_gross.', ';
//            echo $product_net.', ';
//            echo $semi_id.', ';
//            echo $semi_gross.', ';
//            echo $semi_net.', ';
//            echo $component_comment.'<br>';



            $mysqli->query("
                            INSERT INTO `recipes`
                            (
                              `recipe_id`,
                              `recipe_name`,
                              `product_id`,
                              `product_gross`,
                              `product_net`,
                              `semi_id`,
                              `semi_gross`,
                              `semi_net`,
                              `component_comment`
                            )
                            VALUES
                            (
                              NULL,
                              '$recipe_name',
                              '$product_id',
                              '$product_gross',
                              '$product_net',
                              '$semi_id',
                              '$semi_gross',
                              '$semi_net',
                              '$component_comment'
                            );
                          ");
        }

        unset($_POST);

    }
    else
// Добавление данных в Базу Данных
    {
        for ($i = 0; $i++ < 8;) {
            $components[] = $_POST['component_id_'.$i];
            $gross[] = $_POST['gross_'.$i];
            $net[] = $_POST['net_'.$i];
            $comment[] = $_POST['component_comment_'.$i];
        }

        for ($i = 0; $i++ < 8;) {
            $j = $i - 1;

            $product_id = $components[$j];
            $product_id = trim($product_id, '$product_');
            $product_gross = $gross[$j];
            $product_net = $net[$j];
// ПОЛУФАБРИКАТЫ ДОБАВИТЬ ПОЗЖЕ !!! а пока пустое значение
            $semi_id = '0';
            $semi_gross = '0';
            $semi_net = '0';
// ПОЗЖЕ !!! а пока пустое значение
            $component_comment = $comment[$j];



//            echo $i.', ';
//            echo $product_id.', ';
//            echo $product_gross.', ';
//            echo $product_net.', ';
//            echo $semi_id.', ';
//            echo $semi_gross.', ';
//            echo $semi_net.', ';
//            echo $component_comment.'<br>';



            $mysqli->query("
                            INSERT INTO `recipes`
                            (
                              `recipe_id`,
                              `recipe_name`,
                              `product_id`,
                              `product_gross`,
                              `product_net`,
                              `semi_id`,
                              `semi_gross`,
                              `semi_net`,
                              `component_comment`
                            )
                            VALUES
                            (
                              NULL,
                              '$recipe_name',
                              '$product_id',
                              '$product_gross',
                              '$product_net',
                              '$semi_id',
                              '$semi_gross',
                              '$semi_net',
                              '$component_comment'
                            );
                          ");
        }

        unset($_POST);
    }
}


?>

<br>
<div class="container">
    <div class="row">
        <!-- Navbar -->
        <nav class="navbar navbar-dark">
            <!-- Brand -->
            <a class="navbar-brand" href="http://www.proskurnin.ru/_sushi/dish.php">Суши-Бар №1</a>
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
        <?php

        echo $_POST['pagetype'];
        echo "<h1 class='display-1'>";

        if ((!isset($_POST['pagetype'])) || ($_POST['pagetype'] == 'recipes'))
        {
            echo "Рецепты";
        }
        else if ($_POST['pagetype'] == 'semis')
        {
            echo "Полуфабрикаты";
        }
        else if ($_POST['pagetype'] == 'presets')
        {
            echo "Комплекты";
        }
        else if ($_POST['pagetype'] == 'dishs')
        {
            echo "Блюда";
        }
        else if ($_POST['pagetype'] == 'sets')
        {
            echo "Сеты";
        }
        else
        {
            echo "Ошибка!";
        }
        echo "</h1>";


        ?>
        <br>
        <form action="dish.php" method="post">
            <button type="submit" name="pagetype" value="semis" class="btn btn-outline-info">Полуфабрикаты</button>
            <button type="submit" name="pagetype" value="presets" class="btn btn-outline-primary">Комплекты</button>
            <button type="submit" name="pagetype" value="recipes" class="btn btn-outline-success">Рецепты</button>
            <button type="submit" name="pagetype" value="dishs" class="btn btn-outline-warning">Блюда</button>
            <button type="submit" name="pagetype" value="sets" class="btn btn-outline-danger">Сеты</button>
        </form>

        <br>

        <?php





        if ($_POST['showtype'] == 'add' || $_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow' || isset($_GET['del']))
        {

            // ФОРМА работы с данными

            // Заголовок поля формы добавления и редактирования данных
            if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow')
            {
                echo "<h4>Редактирование рецепта ".$edit_name."</h4>";
                echo "<div class='editform'>";
            }
            else
            {
                echo "<h4>Добавление нового рецепта</h4>";
                echo "<div class='addform'>";
            }

            echo "
                <form action='dish.php' class='form-horizontal' method='post'>
                    <div class='container'>
                        <div class='form-group row'>";


            // Название рецепта
            echo "<div class='col-xs-12'>";
            // Отображение для редактирования
            if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow')
            {
                echo "<div class='form-group has-warning'>";
                echo "<input type='text' value='".$edit_name."' class='col-xs-3 form-control form-control-warning' id='recipe_name' name='recipe_name'>";
                echo "</div>";
            }
            // Отображение ПЕРВОГО внесения данных
            else if (!isset($_POST['recipe_name']) || $_POST['recipe_name'] == '-1')
            {
                echo "<div class='form-group'>";
                echo "<input type='text' placeholder='Название рецепта' class='col-xs-3 form-control' id='recipe_name' name='recipe_name'>";
                echo "</div>";
            }
            // Отображение если ОШИБКА, данные не указаны для добавления или изменения
            else if ($_POST['recipe_name'] == '0' || $_POST['recipe_name'] == '')
            {
                echo "<div class='form-group has-danger'>";
                echo "<input type='text' placeholder='Название рецепта' class='col-xs-3 form-control form-control-danger' id='recipe_name' name='recipe_name'>";
                echo "</div>";
            }
            // Отображение данных, когда все указано ВЕРНО
            else
            {
                echo "<div class='form-group has-success'>";
                echo "<input type='text' value='".$_POST['recipe_name']."' class='col-xs-3 form-control form-control-success' id='recipe_name' name='recipe_name'>";
                echo "</div>";
            }
            echo "</div>";



            echo "</div>";




            if ($error == 1) {
                $event = 'mistake';
            } else if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow') {
                $event = 'editdoc';

            } else {
                $event = 'firstlook';
            }

            for ($i=0; $i++<8;) echo rowform($i,$event,$edit_name);



            echo "<div class='form-group row'>";

            // Кнопки [Внести изменения] и [Добавить]
            echo "<div class='col-xs-12'>";


            // Отображение для редактирования
            if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow')
            {
                echo "<input type='hidden' name='editrow' value='editrow'>";
                echo "<input type='hidden' name='edit_name' value='".$edit_name."'>";
                echo "<input type='hidden' name='showtype' value='add'>";
                echo "<button type='submit' name='add' value='submit' class='btn btn-outline-warning pull-right'>Внести изменение</button>";
            }
            // Отображение ПЕРВОГО внесения данных
            else
            {
                echo "<input type='hidden' name='showtype' value='add'>";
                echo "<button type='submit' name='add' value='submit' class='btn btn-outline-primary pull-right'>Добавить рецепт</button>";
            }
            echo "</div>";

            echo "
                        </div>
                    </div>
                </form>
                </div>
                    
            ";


            // Конец ФОРМЫ










            echo "
                <br>
                <table class='table table-hover'>
                    <thead>
                    <tr>
                        <th>№ п/п</th>
                        <th>Наименование</th>
                        <th>Вес</th>
                        <th>Стоимость</th>
                        <th>Белки</th>
                        <th>Жиры</th>
                        <th>Углеводы</th>
                        <th>Эн.ценность</th>
                        <th>Редакт.</th>
                    </tr>
                    </thead>
                    <tbody>                    
                ";


            $result_set = $mysqli->query("SELECT * FROM `recipes`");
            editTable ($result_set);


            echo "
                    </tbody>
                </table>

                <br>
                
                </div>
                    
            ";
// Режим просмотра таблицы
        } else {



            echo "
            <br>
            <table class='table table-hover'>
                <thead>
                <tr>
                    <th>№ п/п</th>
                    <th>Наименование</th>
                    <th>Вес</th>
                    <th>Стоимость</th>
                    <th>Белки</th>
                    <th>Жиры</th>
                    <th>Углеводы</th>
                    <th>Эн.ценность</th>
                </tr>
                </thead>

                <tbody>

                ";

            $result_set = $mysqli->query("SELECT * FROM `recipes`");
            showTable ($result_set);

            echo "
                </tbody>
            </table>
		
	    <br>
            <form class='form-inline' action='dish.php' method='post'>
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