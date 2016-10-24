<!DOCTYPE html>
<html lang="ru">
<?php


// Адрес страницы во всех формах
$urlform = 'semi.php';
// Название таблицы БД, с которой работаем, добавляется в конце s. Имеем имяs
// Поле имя в данной таблице обызательно имя_name
// Поле id, если нужно, имеет вид имя_id. Связи таблиц решил делать через name. Нужно чтобы было уникальным.
$tabname = 'semi';

// Пароль на редактирование данной страницы
$password = '11';
// Включение ДИАГНОСТИКИ переменных (on/off)
$diagnostics_var = 'on';
// Включение ДИАГНОСТИКИ событий (on/off)
//$diagnostics_event = 'on';


?>
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


//        Строим строки с полями формы

function rowform ($i,$event,$edit_name,$tabname) {
//    if ($event == 'event_first') {
//
//        $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
//        $mysqli->query("SET NAMES 'utf8'");
//
//        $options_products = '';
//        $query = "SELECT * FROM `products`";
//        $selproduct = $mysqli->query($query) or die($query);
//        while (($optproduct = $selproduct->fetch_assoc()) != false)
//        {
//            $options_products = $options_products."<option value='product_".$optproduct['product_id']."'>".$optproduct['product_name']."</option>";
//        }
//        $mysqli->close();
//
//
//        $rowOfComponent = "
//        
//        <div id='add.$i' class='row add'>
//        
//        <!-- Компонент рецепта -->
//            <div class='col-xs-4'>
//                <div class='form-group'>
//                <select class='form-control' id='component_id_{$i}' name='component_id_{$i}' required>
//                        <option value=''>Выберите компонент №{$i}</option>
//                        <option value='0'>- не использовать -</option>
//                        <optgroup label='Сырьё и упаковка'>
//                            {$options_products}
//                        </optgroup>
//                </select>
//                </div>
//            </div>
//
//
//        <!-- Количество компонента БРУТТО -->
//            <div class='col-xs-2'>
//                <div class='form-group'>              
//                    <input type='number' min='0.001' max='5' step='0.001' placeholder='Брутто' class='col-xs-2 form-control' id='gross_{$i}' name='gross_{$i}' required>
//                </div>
//            </div>
//
//
//        <!-- Количество компонента НЕТТО -->
//            <div class='col-xs-2'>
//                <div class='form-group'>
//                    <input type='number' min='0.001' max='5' step='0.001' placeholder='Нетто' class='col-xs-2 form-control' id='net_{$i}' name='net_{$i}' required>
//                </div>
//            </div>
//
//
//        <!-- Комментарий к компоненту -->
//            <div class='col-xs-3'>
//                <div class='form-group'>
//                    <input type='text' placeholder='Комментарий' class='col-xs-4 form-control' id='component_comment_{$i}' name='component_comment_{$i}'>
//                </div>
//            </div>
//        
//        
//        <!-- Управляющие конструкции -->
//            <div class='col-xs-1'>
//                <div class='form-group' style='vertical-align: middle;'>
//                    <i class='fa fa-plus' aria-hidden='true' style='color: green;'></i>
//                    &nbsp;&nbsp;
//                    <i class='fa fa-minus' aria-hidden='true' style='color: red;'></i>
//                
//                </div>
//            </div>
//        </div>
//        ";
//    }
    if ($event == 'event_mistake') {


//       ДИАГНОСТИКА
//
//        echo 'Строка = <span style="color: red;">'.$i.'</span><br>';
//        echo 'Компонент: <span style="color: red;">'.(!isset($_POST['component_id_'.$i]) || $_POST['component_id_'.$i] == '0' || $_POST['component_id_'.$i] == '').'</span>';
//        echo ' - значение: <span style="color: red;">'.$_POST['component_id_'.$i].'</span><br>';
//        echo 'Брутто: <span style="color: red;">'.(!isset($_POST['gross_'.$i]) || $_POST['gross_'.$i] == '0' || $_POST['gross_'.$i] == '').'</span>';
//        echo ' - значение: <span style="color: red;">'.$_POST['gross_'.$i].'</span><br>';
//        echo 'Нетто: <span style="color: red;">'.(!isset($_POST['net_'.$i]) || $_POST['net_'.$i] == '0' || $_POST['net_'.$i] == '').'</span>';
//        echo ' - значение: <span style="color: red;">'.$_POST['net_'.$i].'</span><br>';
//        echo 'Комментарий: <span style="color: red;">'.(!isset($_POST['component_comment_'.$i]) || $_POST['component_comment_'.$i] == '0' || $_POST['component_comment_'.$i] == '').'</span>';
//        echo ' - значение: <span style="color: red;">'.$_POST['component_comment_'.$i].'</span><br>';
//        echo '<b>Рисуем строку? <span style="color: red;">'.(
//            (!isset($_POST['component_id_'.$i]) || $_POST['component_id_'.$i] == '0' || $_POST['component_id_'.$i] == '') &&
//            (!isset($_POST['gross_'.$i]) || $_POST['gross_'.$i] == '0' || $_POST['gross_'.$i] == '') &&
//            (!isset($_POST['net_'.$i]) || $_POST['net_'.$i] == '0' || $_POST['net_'.$i] == '') &&
//            (!isset($_POST['component_comment_'.$i]) || $_POST['component_comment_'.$i] == '0' || $_POST['component_comment_'.$i] == '')
//        ).'</span></b><br>';
//
//      КОНЕЦ ДИАГНОСТИКИ



        if (
            (!isset($_POST['component_id_'.$i]) || $_POST['component_id_'.$i] == '0' || $_POST['component_id_'.$i] == '') &&
            (!isset($_POST['gross_'.$i]) || $_POST['gross_'.$i] == '0' || $_POST['gross_'.$i] == '') &&
            (!isset($_POST['net_'.$i]) || $_POST['net_'.$i] == '0' || $_POST['net_'.$i] == '') &&
            (!isset($_POST['component_comment_'.$i]) || $_POST['component_comment_'.$i] == '0' || $_POST['component_comment_'.$i] == '')
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
            $mysqli->close();



            $element_component = '';
            $element_gross = '';
            $element_net = '';
            $element_comment = '';


            // Формируем элемент КОМПОНЕНТ
            if ($_POST['component_id_'.$i] == '0' || $_POST['component_id_'.$i] == '') {
                $element_component = '
                <div class="col-xs-4">
                    <div class="form-group has-danger">
                    <select class="form-control form-control-danger" id="component_id_{$i}" name="component_id_{$i}" required>
                        <option value="">Не указано!</option>
                        <option value="0">- не использовать -</option>
                        <optgroup label="Сырьё и упаковка">
                            {$options_products}
                        </optgroup>
                    </select>
                    </div>
                </div>
                ';
            }
            else
            {
                $element_component = '
                <div class="col-xs-4">
                    <div class="form-group has-success">
                    <select class="form-control form-control-success" id="component_id_{$i}" name="component_id_{$i}" required>
                        <option value="{$component_id}">{$select_option}</option>
                        <option value="0">- не использовать -</option>
                        <optgroup label="Сырьё и упаковка">
                            {$options_products}
                        </optgroup>
                    </select>
                    </div>
                </div>
                ';
            }

            // Формируем элемент БРУТТО
            $element_gross = '
            <div class="col-xs-2">
                <div class="form-group has-success">
                    <div class="input-group">
                        <input type="number" min="0.001" max="5" step="0.001" value="'.$_POST['gross_'.$i].'" class="col-xs-3 form-control form-control-success" id="gross_{$i}" name="gross_{$i}" required>
                    </div>
                </div>
            </div>
            ';


            // Формируем элемент НЕТТО
            $element_net = '
            <div class="col-xs-2">
                <div class="form-group has-success">
                    <div class="input-group">
                        <input type="number" min="0.001" max="5" step="0.001" value="'.$_POST['net_'.$i].'" class="col-xs-3 form-control form-control-success" id="net_{$i}" name="net_{$i}" required>
                    </div>
                </div>
            </div>
            ';

            // Формируем элемент КОММЕНТАРИЙ
            if ($_POST['component_comment_'.$i] == '0' || $_POST['component_comment_'.$i] == '') {
                $element_comment = '
                <div class="col-xs-3">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" placeholder="Комментарий" class="col-xs-3 form-control" id="component_comment_{$i}" name="component_comment_{$i}">
                        </div>
                    </div>
                </div>
                ';
            }
            else
            {
                $element_comment = '
                <div class="col-xs-3">
                    <div class="form-group has-success">
                        <div class="input-group">
                            <input type="text" value="'.$_POST['component_comment_'.$i].'" class="col-xs-3 form-control form-control-success" id="component_comment_{$i}" name="component_comment_{$i}">            
                        </div>
                    </div>
                </div>
                ';
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
    if ($event == 'event_edit') {

        $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
        $mysqli->query("SET NAMES 'utf8'");

        $query = "SELECT  `product_id` FROM  `{$tabname}s` WHERE  `{$tabname}_name` =  '$edit_name'";
        $db_components = $mysqli->query($query) or die($query);
        while (($db_element_component = $db_components->fetch_assoc()) != false)
        {
            $element_component_db[] = array_shift($db_element_component);
        }
        $query = "SELECT  `product_gross` FROM  `{$tabname}s` WHERE  `{$tabname}_name` =  '$edit_name'";
        $db_gross = $mysqli->query($query) or die($query);
        while (($db_element_gross = $db_gross->fetch_assoc()) != false)
        {
            $element_gross_db[] = array_shift($db_element_gross);
        }
        $query = "SELECT  `product_net` FROM  `{$tabname}s` WHERE  `{$tabname}_name` =  '$edit_name'";
        $db_net = $mysqli->query($query) or die($query);
        while (($db_element_net = $db_net->fetch_assoc()) != false)
        {
            $element_net_db[] = array_shift($db_element_net);
        }
        $query = "SELECT  `component_comment` FROM  `{$tabname}s` WHERE  `{$tabname}_name` =  '$edit_name'";
        $db_comment = $mysqli->query($query) or die($query);
        while (($db_element_comment = $db_comment->fetch_assoc()) != false)
        {
            $element_comment_db[] = array_shift($db_element_comment);
        }
        $j = $i - 1;


//    ДИАГНОСТИКА
//
        echo 'шаг номер '.$i.'<br>';
        echo '<b>$element_component['.$j.'] = '.$element_component[$j].'</b><br>';
        echo '<b>$element_gross['.$j.'] = '.$element_gross[$j].'</b><br>';
        echo '<b>$element_net['.$j.'] = '.$element_net[$j].'</b><br>';
        echo '<b>$element_comment['.$j.'] = '.$element_comment[$j].'</b><br>';
        echo '<br>';
//
//    КОНЕЦ ДИАГНОСТИКИ





        if (
            (!isset($_POST['component_id_'.$i]) || $_POST['component_id_'.$i] == '0' || $_POST['component_id_'.$i] == '') &&
            (!isset($_POST['gross_'.$i]) || $_POST['gross_'.$i] == '0' || $_POST['gross_'.$i] == '') &&
            (!isset($_POST['net_'.$i]) || $_POST['net_'.$i] == '0' || $_POST['net_'.$i] == '') &&
            (!isset($_POST['component_comment_'.$i]) || $_POST['component_comment_'.$i] == '0' || $_POST['component_comment_'.$i] == '')
        )

        {

            $component_id = $element_component_db[$j];

            $options_products = '';
            $selproduct = $mysqli->query("SELECT * FROM `products`") or die();
            while (($optproduct = $selproduct->fetch_assoc()) != false)
            {
                if ($component_id == $optproduct['product_id'])
                {
                    // Определяем выбранную позицию
                    $select_option = $optproduct['product_name'];
                }
                // Строим полный список для select
                $options_products = $options_products.'<option value="product_'.$optproduct['product_id'].'">'.$optproduct['product_name'].'</option>';
            }
            $mysqli->close();





            // Формируем элемент КОМПОНЕНТ
            if ($component_id == '0' || $component_id == '') {
                $element_component = "
                <div class='col-xs-4'>
                    <div class='form-group'>
                    <select class='form-control' id='component_id_{$i}' name='component_id_{$i}' required>
                        <option value=''>Выберите компонент {$i}</option>
                        <option value='0'>- не использовать -</option>
                        <optgroup label='Сырьё и упаковка'>
                            {$options_products}
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
                    <select class='form-control form-control-warning' id='component_id_{$i}' name='component_id_{$i}' required>
                        <option value='{$component_id}'>{$select_option}</option>
                        <option value='0'>- не использовать -</option>
                        <optgroup label='Сырьё и упаковка'>
                            {$options_products}
                        </optgroup>
                    </select>
                    </div>
                </div>
                ";
            }

            // Формируем элемент БРУТТО
            $element_gross = "
            <div class='col-xs-2'>
                <div class='form-group has-warning'>
                    <div class='input-group'>
                        <input type='number' min='0.001' max='5' step='0.001' value='".$element_gross_db[$j]."' class='col-xs-3 form-control form-control-warning' id='gross_{$i}' name='gross_{$i}' required>
                    </div>
                </div>
            </div>
            ";


            // Формируем элемент НЕТТО
            $element_net = "
            <div class='col-xs-2'>
                <div class='form-group has-warning'>
                    <div class='input-group'>
                        <input type='number' min='0.001 ' max='5' step='0.001' value='".$element_net_db[$j]."' class='col-xs-3 form-control form-control-warning' id='net_{$i}' name='net_{$i}' required>
                    </div>
                </div>
            </div>
            ";


            // Формируем элемент КОММЕНТАРИЙ
            if ($element_comment_db[$j] == '0' || $element_comment_db[$j] == '') {
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
                            <input type='text' value='".$element_comment_db[$j]."' class='col-xs-3 form-control form-control-warning' id='component_comment_{$i}' name='component_comment_{$i}'>            
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


//                Строим таблицу
//      ДОБАВЛЕНИЕ - УДАЛЕНИЕ - РЕДАКТИРОВАНИЕ

function editTable ($result_set,$tabname)
{

    $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
    $mysqli->query("SET NAMES 'utf8'");

    $counter = 0;
    $npp = 0;
    $item_name = '';
    $item_name_check = '';

    while (($row = $result_set->fetch_assoc()) != false) {
        if ($item_name_check !== $row[$tabname.'_name'])
        {
            if ($npp !== 0)
            {
                echo "
                    <tr>
                    <td>" . $npp . "</td>
                    <td>" . $item_name . "</td>
                    <td>" . $item_amount . "</td>
                    <td>" . $item_cost . "</td>
                    <td>" . $iseb_protein . "</td>
                    <td>" . $item_fat . "</td>
                    <td>" . $item_carbohydrate . "</td>
                    <td>" . $item_energy . "</td>
                    <td>
                    <a name='del' href=".$urlform."?del=".urlencode($item_name).">
                    <i class='fa fa-times' aria-hidden='true' style='color: red;'></i>
                    </a>
            
                    &nbsp;&nbsp;&nbsp;
            
                    <a name='edit' href=".$urlform."?editrow=editrow&edit_name=".urlencode($item_name).">
                    <i class='fa fa-pencil-square-o' aria-hidden='true' style='color: cornflowerblue;'></i>
                    </a>
                </td>
                </tr>";

            }
            $npp++;

            $item_amount = 0;
            $item_cost = 0;
            $item_protein = 0;
            $item_fat = 0;
            $item_carbohydrate = 0;
            $item_energy = 0;
        }

        $item_name = $row[$tabname.'_name'];
        $item_name_check = $row[$tabname.'_name'];

        foreach ($row as $k => $v) {
            if (($k == $tabname.'_name') && ($v == $item_name)) {
                $query = "SELECT * FROM `products` WHERE `product_id` = ".$row['product_id'];
                $dbproduct = $mysqli->query($query) or die($query);
                $product = $dbproduct->fetch_assoc();
                $item_amount = $item_amount + ($row["product_net"]);
                $item_cost = $item_cost + ($row["product_gross"] * $product["price_online"]);
                $item_protein = $item_protein + ($row["product_net"] * $product["protein"]);
                $item_fat = $item_fat + ($row["product_net"] * $product["fat"]);
                $item_carbohydrate = $item_carbohydrate + ($row["product_net"] * $product["carbohydrate"]);
                $item_energy = $item_energy + ($row["product_net"] * $product["energy"]);
            }
        }
    }
    if ($npp !== 0)
    {
        echo "
            <tr>
            <td>" . $npp . "</td>
            <td>" . $item_name . "</td>
            <td>" . $item_amount . "</td>
            <td>" . $item_cost . "</td>
            <td>" . $item_protein . "</td>
            <td>" . $item_fat . "</td>
            <td>" . $item_carbohydrate . "</td>
            <td>" . $item_energy . "</td>
            <td>
            <a name='del' href=".$urlform."?del=".urlencode($item_name).">
            <i class='fa fa-times fa' aria-hidden='true' style='color: red;'></i>
            </a>
    
            &nbsp;&nbsp;&nbsp;
    
            <a name='edit' href=".$urlform."?editrow=editrow&edit_name=".urlencode($item_name).">
            <i class='fa fa-pencil-square-o fa' aria-hidden='true' style='color: cornflowerblue;'></i>
            </a>
            </td>
            </tr>";
    }

    $mysqli->close();
}


//                Строим таблицу
//                   ПРОСМОТР

function showTable ($result_set,$tabname)
{

    $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
    $mysqli->query("SET NAMES 'utf8'");

    $counter = 0;
    $npp = 0;
    $item_name = '';
    $item_name_check = '';

    while (($row = $result_set->fetch_assoc()) != false) {
        if ($item_name_check !== $row[$tabname.'_name'])
        {
            if ($npp !== 0)
            {
                echo "
                    <tr>
                    <td>" . $npp . "</td>
                    <td>" . $item_name . "</td>
                    <td>" . $item_amount . "</td>
                    <td>" . $item_cost . "</td>
                    <td>" . $item_protein . "</td>
                    <td>" . $item_fat . "</td>
                    <td>" . $item_carbohydrate . "</td>
                    <td>" . $item_energy . "</td>
                    </tr>";
            }
            $npp++;

            $item_amount = 0;
            $item_cost = 0;
            $item_protein = 0;
            $item_fat = 0;
            $item_carbohydrate = 0;
            $item_energy = 0;
        }

        $item_name = $row[$tabname.'_name'];
        $item_name_check = $row[$tabname.'_name'];

        foreach ($row as $k => $v) {
            if (($k == $tabname.'_name') && ($v == $item_name)) {
                $dbproduct = $mysqli->query("SELECT * FROM `products` WHERE  `product_id` = " . $row['product_id']) or die();
                $product = $dbproduct->fetch_assoc();

                $item_amount = $item_amount + ($row["product_net"]);

//                    echo $row['product_id'] . ": ";
//                    echo $item_cost . ' = ' . $item_cost . ' + (' . $row["product_gross"] . ' * ' . $product["price_online"] . ')<br>';
                $item_cost = $item_cost + ($row["product_gross"] * $product["price_online"]);
//                    echo "$$$ " . $item_cost . "<br>";

                $item_protein = $item_protein + ($row["product_net"] * $product["protein"]);
                $item_fat = $item_fat + ($row["product_net"] * $product["fat"]);
                $item_carbohydrate = $item_carbohydrate + ($row["product_net"] * $product["carbohydrate"]);
                $item_energy = $item_energy + ($row["product_net"] * $product["energy"]);
            }
        }
    }
    if ($npp !== 0)
    {
        echo "
            <tr>
            <td>" . $npp . "</td>
            <td>" . $item_name . "</td>
            <td>" . $item_amount . "</td>
            <td>" . $item_cost . "</td>
            <td>" . $item_protein . "</td>
            <td>" . $item_fat . "</td>
            <td>" . $item_carbohydrate . "</td>
            <td>" . $item_energy . "</td>
        </tr>";
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


//   Функция добавления данных из таблицы recipеs
//          ЭТО НЕДОДЕЛАННАЯ ФУНКЦИЯ !!!

function rowadd ($num_rows) {

    echo 'Hi ADDITOR!<br>';
    echo '$_POST[component_id_1] = '.$_POST['component_id_1'].'<br>';

    $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
    $mysqli->query("SET NAMES 'utf8'");





    $mysqli->close();
}


//        Функция подсчёта количества строк

function rowscounter ($row_name,$tabname){
    $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
    $mysqli->query("SET NAMES 'utf8'");
    $query = "SELECT  `product_id` FROM  `{$tabname}s` WHERE  `{$tabname}_name` =  '$row_name'";
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

// и $name для отображения в поле Название рецепта
if (isset($_GET['edit_name'])) {$name = $edit_name = $_GET['edit_name'];}
else if (isset($_POST['edit_name'])) {$name = $edit_name = $_POST['edit_name'];}
else {$name = $edit_name = -1;}

// и $add_name для внесения в поле Название рецепта
if (isset($_POST['add_name'])) {$add_name = $_POST['add_name'];}
else if (isset($_POST['add_name_edit'])) {$add_name = $_POST['add_name_edit'];}
else if (isset($_POST['add_name_mistake'])) {$add_name = $_POST['add_name_mistake'];}
else {$add_name = -1;}


// Устанавливаем число строк формы
// На первом шагу определяем количество строк, которые используются в рецепте для редактирования
if (isset($_GET['edit_name']) || isset($_POST['edit_name'])) {$num_rows = rowscounter($edit_name,$tabname);}
// Второй и третий шаг установка количества строк если параметр передан очевидно
else if ($_POST['num_rows'] > 0) {$num_rows = $_POST['num_rows'];}
else if ($_GET['num_rows'] > 0) {$num_rows = $_GET['num_rows'];}
// по умолчанию (если иное не заданно) используем 3 строк для вывода формы
else {$num_rows = 3;}

// Проверка на уникальность название. Название должно быть уникальным.
// Берём то название, что хотим добавить и сравниваем с теми, что есть в базе.
// Если случается совпадение - перезагружаем форму с ошибкой на поле названия
// и выводом алерта с сообщением об ошибке
$i = 0;
$query = "SELECT `{$tabname}_name` FROM `{$tabname}s`";
$db_names = $mysqli->query($query) or die($query);

//    echo "<h3>Проверка на уникальность названия $add_name </h3><br>";
while (($db_item_names = $db_names->fetch_assoc()) != false) {

//    $i++;
//    echo '<b>Шаг номер - '.$i.'<br></b>';
//    echo 'add_name - '.($_POST['add_name'] == $db_item_names[$tabname.'_name']).'<br>';
//    echo 'add_name_edit - '.($_POST['add_name_edit'] == $db_item_names[$tabname.'_name']).'<br>';
//    echo 'add_name_mistake - '.($_POST['add_name_mistake'] == $db_item_names[$tabname.'_name']).'<br>';
//    echo 'add/edit - '.($add_name !== $edit_name).'<br>';
//    echo '$add_name = '.$add_name.'<br>';
//
//    echo 'results - '.((($_POST['add_name'] == $db_item_names[$tabname.'_name']) ||
//                ($_POST['add_name_edit'] == $db_item_names[$tabname.'_name']) ||
//                ($_POST['add_name_mistake'] == $db_item_names[$tabname.'_name']))
//                &&
//                ($add_name !== $edit_name)
//                &&
//                ($add_name !== '')
//                &&
//                ($add_name !== -1)
//            ).'<br><br>';



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
        $reason = $reason . 'Название полуфабриката уже используется!\u000A';
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
//        НЕ СДЕЛАЛ ВООБЩЕ ПОЛУФАБРИКАТЫ !!!
if ($_POST['actiontype'] == 'add' || $_POST['actiontype'] == 'edit') {

//    $error = 0;
//    $dubl = 0;
//    $num_rows_validator = 0;
//
// Обработчик ошибок - поиск незаполненных полей
// Не нужен этот блок при использовнии проверки в полях
//
//    if ($add_name == '')
//    {
//        $error = 1;
//        $reason = $reason.'Не указано название полуфабриката!\u000A';
//    }
//
//    for ($i = 0; $i++ < $num_rows;) {
//        // echo $_POST['component_id_'.$i];
//        if (isset($_POST['component_id_'.$i]) && $_POST['component_id_'.$i] !== '0')
//        {
//            if (!isset($_POST['gross_'.$i]) || $_POST['gross_'.$i] == '0' || $_POST['gross_'.$i] == '')
//            {
//                // echo $_POST['component_id_'.$i];
//                $error = 1;
//                $reason = $reason.'В строке '.$i.' не указан вес Брутто! (компонент указан)\u000A';
//            }
//            if (!isset($_POST['net_'.$i]) || $_POST['net_'.$i] == '0' || $_POST['net_'.$i] == '')
//            {
//                // echo $_POST['net_'.$i];
//                $error = 1;
//                $reason = $reason.'В строке '.$i.' не указан вес Нетто! (компонент указан)\u000A';
//            }
//            $names_arr[] = $_POST['component_id_'.$i];
//            $num_rows_validator++;
//        }
//        else if ($_POST['gross_'.$i] > 0)
//        {
//            if (!isset($_POST['component_id_'.$i]) || $_POST['component_id_'.$i] == '0' || $_POST['component_id_'.$i] == '')
//            {
//                // echo $_POST['component_id_'.$i];
//                $error = 1;
//                $reason = $reason.'В строке '.$i.' не указан Компонент! (вес брутто указан)\u000A';
//            }
//            if (!isset($_POST['net_'.$i]) || $_POST['net_'.$i] == '0' || $_POST['net_'.$i] == '')
//            {
//                // echo $_POST['net_'.$i];
//                $error = 1;
//                $reason = $reason.'В строке '.$i.' не указан вес Нетто! (вес брутто указан)\u000A';
//            }
//            $num_rows_validator++;
//        }
//        else if ($_POST['net_'.$i] > 0)
//        {
//            if (!isset($_POST['component_id_'.$i]) || $_POST['component_id_'.$i] == '0' || $_POST['component_id_'.$i] == '')
//            {
//                // echo $_POST['component_id_'.$i];
//                $error = 1;
//                $reason = $reason.'В строке '.$i.' не указан Компонент! (вес нетто указан)\u000A';
//            }
//            if (!isset($_POST['gross_'.$i]) || $_POST['gross_'.$i] == '0' || $_POST['gross_'.$i] == '')
//            {
//                // echo $_POST['gross_'.$i];
//                $error = 1;
//                $reason = $reason.'В строке '.$i.' не указан вес Брутто! (вес нетто указан)\u000A';
//            }
//            $num_rows_validator++;
//        }
//        else if (!isset($_POST['component_comment_'.$i]) || $_POST['component_comment_'.$i] == '0' || $_POST['component_comment_'.$i] == '')
//        {
//            $num_rows_validator++;
//        }
//        else
//        {
//            if ($error == 0)
//            {
//                $error = 0;
//                $reason = $reason.'В строке '.$i.' нет ошибок!\u000A';
//            }
//        }
//    }



//         Проверка на дубликаты строки компоненты
//                    НУЖНО ДОДЕЛАТЬ
//
//    $names_arr = array_count_values($names_arr);
//    foreach($names_arr as $kk=>$vv) {
//        if ($vv > 1) {
//            $error = 1;
//            $reason = $reason.'Дублируются компоненты!\u000A';
//            break;
//        }
//    }






//  Подсчёт используемых реально строк
//  Раньше считало в проверке пустых полей
//    $num_rows = $num_rows_validator;




// Если мы выявили ошибку, значит переменная "событий" приняла значение "ошибка"
// Нужно искать дубликаты компонентов и дубликаты имени полуфабриката
// Емли они есть нужно выдавать ошибку и исправлять дубликат

//    if ($error == 1) $event = 'event_mistake';



//                         Начало блока
//                ЗАПОЛНЕНИЕ И РЕДАКТИРОВАНИЕ БД


// Если на предыдущем шаге выявили ошибки, в нашем случае - это пустые (не заполненные) поля строк
// В строке все поля, кроме комментария обязательные для заполнения, если заполнена хотябы одна ячейка

    if ($event == 'event_mistake')
    {

        echo "<script>alert('$reason');</script>";
    }


// Действие по редактированию - Удалить и Создать снова
// Нужно переделать через UPDATE
    else if ($_POST['actiontype'] == 'edit') {

        $num_rows = rowscounter($edit_name,$tabname);

        $query = "SELECT  `{$tabname}_id` FROM  `{$tabname}s` WHERE  `{$tabname}_name` =  '$edit_name'";
        $db_components = $mysqli->query($query) or die($query);
        while (($db_element_component = $db_components->fetch_assoc()) != false)
        {
            $element_id_arr[] = $db_element_component[$tabname.'_id'];
        }



        if ($diagnostics_event == 'on') {
//     Диагностика данных, которые мы вносим!
//           Блок разделён на три части
//             Это блок №1 - "хидер"
            echo '<div class="diagnostika-2">';
//                 НЕ ИСПОЛЬЗУЕМ
//     потому что не влезает по высоте на экран

            echo "<h2>Hi EDITOR!</h2>";
            echo 'Редактирум: <span style="color: red;">'.$edit_name.'</span><br>';
            echo 'Новое имя: <span style="color: red;">'.$add_name.'</span><br>';
            echo 'Строк в рецепте: <span style="color: red;">'.$num_rows.'</span><br>';
            echo '<hr>';
        }



        for ($i = 0; $i++ < $num_rows;) {
            $j = $i - 1;

            $element_id = $element_id_arr[$j];
            $product_id = $_POST['component_id_'.$i];
            $product_id = trim($product_id, 'product_');
            $product_gross = $_POST['gross_'.$i];
            $product_net = $_POST['net_'.$i];
            $component_comment = $_POST['component_comment_'.$i];


            if ($product_id == '0')
            {

                $query = "DELETE FROM `{$tabname}s` WHERE `{$tabname}_id` = '$element_id'";
                /* Выполняем запрос. Если произойдет ошибка - вывести ее. */
                $mysqli->query($query) or die($query);

                if ($diagnostics_event == 'on') {
//     Диагностика данных, которые мы вносим!
//           Блок разделён на три части
//             Это блок №2 - "данные"
                    echo '<b>Обработка строки: ' . $i . '<br></b>';
                    echo '<span style="color: red;">Выбрано "не использовать" !!! Удалили !!!</span><br><br>';
                }
            }
            else
            {
                if ($diagnostics_event == 'on') {
//     Диагностика данных, которые мы вносим!
//           Блок разделён на три части
//             Это блок №2 - "данные"

                    echo '<b>Обработка строки: ' . $i . '<br></b>';
                    echo 'ID строки: <span style="color: red;">' . $element_id . '</span> <b>||</b> ';
                    echo 'ID компонента: <span style="color: red;">' . $product_id . '</span> <b>||</b> ';
                    echo 'Вес Брутто: <span style="color: red;">' . $product_gross . '</span> <b>||</b> ';
                    echo 'Вес Нетто: <span style="color: red;">' . $product_net . '</span> <b>||</b> ';
                    echo 'Комментарий: <span style="color: red;">' . $component_comment . '</span><br><br>';

                    $query = "UPDATE `{$tabname}s`
                          SET                              
                          `{$tabname}_name` = '$add_name',
                          `product_id` = '$product_id',
                          `product_gross` = '$product_gross',
                          `product_net` = '$product_net',
                          `component_comment` = '$component_comment'
                          WHERE  
                          `{$tabname}_id` = '$element_id'";
                    /* Выполняем запрос. Если произойдет ошибка - вывести ее. */
                    $mysqli->query($query) or die($query);
                }
            }

        }


        if ($diagnostics_event == 'on') {
//     Диагностика данных, которые мы вносим!
//           Блок разделён на три части
//             Это блок №3 - "футер"
                   echo '</div>';
//                НЕ ИСПОЛЬЗУЕМ
//     потому что не влезает по высоте на экран
        }




    }
// Добаление данных в Базу Данных
// Работает хорошо
    else if($_POST['actiontype'] == 'add') {

        if ($diagnostics_event == 'on') {
//     Диагностика данных, которые мы вносим!
//           Блок разделён на три части
//             Это блок №1 - "хидер"
            echo '<div class="diagnostika-2">';
//                 НЕ ИСПОЛЬЗУЕМ
//     потому что не влезает по высоте на экран

            echo "<h2>Hi NEW ITEM!</h2>";
            echo 'Вносим: <span style="color: red;">'.$add_name.'</span><br>';
            echo 'Количество строк: <span style="color: red;">'.$num_rows_validator.'</span><br><br>';
        }


        for ($i = 0; $i++ < $num_rows;) {


            $product_id = $_POST['component_id_'.$i];
            $product_id = trim($product_id, 'product_');
            $product_gross = $_POST['gross_'.$i];
            $product_net = $_POST['net_'.$i];
            $component_comment = $_POST['component_comment_'.$i];

            if ($product_id == '0' || $product_gross == '0' || $product_net == '0')
            {
                if ($diagnostics_event == 'on') {
//     Диагностика данных, которые мы вносим!
//           Блок разделён на три части
//             Это блок №2 - "данные"
                    echo '<b>Обработка строки: ' . $i . '<br></b>';
                    echo '<span style="color: red;">Строка с нулём !!! Пропускаем !!!</span><br><br>';
                }
            }
            else
            {

                if ($diagnostics_event == 'on') {
    //     Диагностика данных, которые мы вносим!
    //           Блок разделён на три части
    //             Это блок №2 - "данные"
                    echo '<b>Обработка строки: ' . $i . '<br></b>';
                    echo 'ID компонента: <span style="color: red;">' . $product_id . '</span> <b>||</b> ';
                    echo 'Вес Брутто: <span style="color: red;">' . $product_gross . '</span> <b>||</b> ';
                    echo 'Вес Нетто: <span style="color: red;">' . $product_net . '</span> <b>||</b> ';
                    echo 'Комментарий: <span style="color: red;">' . $component_comment . '</span><br><br>';
                }


                $query = "INSERT INTO `{$tabname}s`
                (`{$tabname}_id`,`{$tabname}_name`,`product_id`,`product_gross`,`product_net`,`component_comment`)
                VALUES  (NULL,'$add_name','$product_id','$product_gross','$product_net','$component_comment')";
                /* Выполняем запрос. Если произойдет ошибка - вывести ее. */
                $mysqli->query($query) or die($query);
            }
        }



        if ($diagnostics_event == 'on') {
//     Диагностика данных, которые мы вносим!
//           Блок разделён на три части
//             Это блок №3 - "футер"
                   echo '</div>';
//                НЕ ИСПОЛЬЗУЕМ
//     потому что не влезает по высоте на экран
        }




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
            <a class="navbar-brand" href="http://www.proskurnin.ru/_sushi/index.php">Суши-Бар №1</a>
            <!-- Links -->
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="sale.php">Продажи</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Сырьё</a>
                    <div class="dropdown-menu" aria-labelledby="Data">
                        <a class="dropdown-item" href="product.php">Склад</a>
                        <a class="dropdown-item" href="product_purchase.php">Приход</a>
                        <a class="dropdown-item" href="product_salvage.php">Списание</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Данные</a>
                    <div class="dropdown-menu" aria-labelledby="Data">
                        <a class="dropdown-item" href="product.php">Продуты</a>
                        <a class="dropdown-item" href="semi.php">Полуфабрикаты</a>
                        <a class="dropdown-item" href="preset.php">Комплекты</a>
                        <a class="dropdown-item" href="recipe.php">Рецепты</a>
                        <a class="dropdown-item" href="dish.php">Блюда</a>
                        <a class="dropdown-item" href="set.php">Сеты</a>
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


        echo "<h1 class='display-1'>Полуфабрикаты</h1>";


        ?>
        <br>

<!--      Блок с кнопками навигации по заполнению данных в меню       -->
<!-- Должна отображаться структура наполнения от Полуфабриката к Сету -->

        <div>
            <a href="semi.php" class="btn btn-info">Полуфабрикаты</a>
            <a href="preset.php" class="btn btn-outline-primary">Комплекты</a>
            <a href="recipe.php" class="btn btn-outline-success">Рецепты</a>
            <a href="dish.php" class="btn btn-outline-warning">Блюда</a>
            <a href="set.php" class="btn btn-outline-danger">Сеты</a>
        </div>

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
                echo "
                    <h4>Редактирование полуфабриката $name</h4>
                        <div class='editform'>
                        <form action='".$urlform."' class='form-horizontal' method='post'>
                            <div class='container'>
                                <div class='form-group row'>
                                    <div class='col-xs-12'>
                                        <div class='form-group has-warning'>
                                            <input type='text' value='".$name."' class='col-xs-3 form-control form-control-warning' id='add_name_edit' name='add_name_edit' required>
                                        </div>";
            }
            else if ($showtype == 'show_mistake')
            {
                echo "
                    <h4>Ошибка в полуфабрикате $name</h4>
                        <div class='mistakeform'>
                        <form action='".$urlform."' class='form-horizontal' method='post'>
                            <div class='container'>
                                <div class='form-group row'>
                                    <div class='col-xs-12'>
                                        <div class='form-group has-danger'>
                                            <input type='text' value='".$name."' class='col-xs-3 form-control form-control-danger' id='add_name_mistake' name='add_name_mistake' required>
                                        </div>";
            }
            else if ($showtype == 'show_manag' || isset($_GET['del']))
            {
                echo "
                    <h4>Добавление нового полуфабриката</h4>
                        <div class='addform'>
                        <form action='".$urlform."' class='form-horizontal' method='post'>
                            <div class='container'>
                                <div class='form-group row'>
                                    <div class='col-xs-12'>";
                                        if ($event == 'event_first')
                                        {
                                            echo "
                                                <div class='form-group'>
                                                    <input type='text' placeholder='Название рецепта' class='col-xs-3 form-control' id='add_name' name='add_name' required>
                                                </div>";
                                        }
                                        // Отображение данных, когда все указано ВЕРНО
                                        else
                                        {
                                            echo "
                                                <div class='form-group has-success'>
                                                    <input type='text' value='".$name."' class='col-xs-3 form-control form-control-success' id='add_name' name='add_name' required>
                                                </div>";
                                        }
            }
            echo "
                </div>  
                </div>"; // Закрываем <div class='col-xs-12'> и строку <div class='form-group row'>


            $options_products = '';
            $query = "SELECT * FROM `products`";
            $selproduct = $mysqli->query($query) or die($query);
            while (($optproduct = $selproduct->fetch_assoc()) != false)
            {
                $options_products = $options_products.'<option value="product_'.$optproduct['product_id'].'">'.$optproduct['product_name'].'</option>';
            }


            echo '<div id="add_field_area">';
                for ($i=0; $i++ < $num_rows;)
                {
                    echo "
                        <div id='add$i' class='add row'>
        
                    <!-- Компонент рецепта -->
                        <div class='col-xs-4'>
                            <div class='form-group'>
                            <select class='form-control' id='component_id_{$i}' name='component_id_{$i}' required>
                                    <option value=''>Выберите компонент №{$i}</option>
                                    <option value='0'>- не использовать -</option>
                                    <optgroup label='Сырьё и упаковка'>
                                        {$options_products}
                                    </optgroup>
                            </select>
                            </div>
                        </div>
            
            
                    <!-- Количество компонента БРУТТО -->
                        <div class='col-xs-2'>
                            <div class='form-group'>              
                                <input type='number' min='0.001' max='5' step='0.001' placeholder='Брутто' class='col-xs-2 form-control' id='gross_{$i}' name='gross_{$i}' required>
                            </div>
                        </div>
            
            
                    <!-- Количество компонента НЕТТО -->
                        <div class='col-xs-2'>
                            <div class='form-group'>
                                <input type='number' min='0.001' max='5' step='0.001' placeholder='Нетто' class='col-xs-2 form-control' id='net_{$i}' name='net_{$i}' required>
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
                            <div class='form-group deletebutton' onclick='deleteField({$i});'>
                                <i class='fa fa-times fa' aria-hidden='true' style='color: red; cursor: pointer'></i>
                            </div>
                        </div>
                    </div>
                    ";


                }

            echo "</div>";


//  Вывод строк для внесения в них данных!
//  for ($i=0; $i++ < $num_rows;) echo rowform($i,$event,$edit_name,$tabname);


            echo "<div class='form-group row'>";
            // Кнопки [Внести изменения] и [Добавить]


            // Отображение для редактирования
            if ($showtype == 'show_edit')
            {
                echo "
                <div class='col-xs-6'>
                    <div onclick='addField();' class='btn btn-outline-info addbutton'>Добавить новое поле</div>
                </div>
                <div class='col-xs-6'>
                    <input type='hidden' name='num_rows' value='".$num_rows."'>
                    <input type='hidden' name='edit_name' value='".$name."'>
                    <input type='hidden' name='showtype' value='show_edit'>
                    <input type='hidden' name='actiontype' value='edit'>
                    <button type='submit' name='edititem' class='btn btn-outline-warning pull-right'>Внести изменение</button>
                </div>";
            }
            else if ($showtype == 'show_mistake')
            {
                echo "
                <div class='col-xs-6'>
                    <div onclick='addField();' class='btn btn-outline-info addbutton'>Добавить новое поле</div>
                </div>
                <div class='col-xs-6'>
                    <input type='hidden' name='num_rows' value='".$num_rows."'>
                    <input type='hidden' name='edit_name' value='".$name."'>
                    <input type='hidden' name='showtype' value='show_mistake'>
                    <input type='hidden' name='actiontype' value='edit'>
                    <button type='submit' name='edititem' class='btn btn-outline-danger pull-right'>Исправить данные</button>
                </div>";
            }
            else if ($showtype == 'show_manag' || isset($_GET['del']))
            {
                echo "
                <div class='col-xs-6'>
                    <div onclick='addField();' class='btn btn-outline-info addbutton'>Добавить новое поле</div>
                </div>
                <div class='col-xs-6'>
                    <input type='hidden' name='num_rows' value='".$num_rows."'>
                    <input type='hidden' name='showtype' value='show_manag'>
                    <input type='hidden' name='actiontype' value='add'>
                    <button type='submit' name='addnewitem' class='btn btn-outline-primary pull-right'>Добавить рецепт</button>
                </div>";
            }


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

            // Создаём массив для работы с ним
            $items_result_set = $mysqli->query("SELECT * FROM `{$tabname}s`");
            echo editTable ($items_result_set,$tabname);


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

            // Создаём массив для работы с ним
            $items_result_set = $mysqli->query("SELECT * FROM `{$tabname}s`");
            // Наполняем таблицу строками
            echo showTable ($items_result_set,$tabname);

            echo "
                </tbody>
            </table>
		
	    <br>
            <form action='".$urlform."' method='post' class='form-inline'>
                <input type='password' placeholder='Пароль для редактирования' class='form-control' id='passforedit' name='passforedit' size='20'>
				<label for='num_rows'>Строк для добавления: </label>
                <input type='number' value='3' class='form-control' id='num_rows' name='num_rows' min='1' max='20' size='5'>
                
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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>
<script type="text/javascript">

    function addField () {

        var telnum_base = $('#add_field_area').find('div.add:last').attr('id').slice(3);
        var telnum = parseInt($('#add_field_area').find('div.add:last').attr('id').slice(3))+1;
/*        alert("telnum_base = "+telnum_base+" telnum = "+telnum); */

        $('div#add_field_area').append('<div id="add'+telnum+'" class="row add"><!-- Компонент рецепта --><div class="col-xs-4"><div class="form-group"><select class="form-control" id="component_id_'+telnum+'" name="component_id_'+telnum+'" required><option value="">Выберите компонент №'+telnum+'</option><option value="0">- не использовать -</option><optgroup label="Сырьё и упаковка"><?php echo $options_products ?></optgroup></select></div></div><!-- Количество компонента БРУТТО --><div class="col-xs-2"><div class="form-group"><input type="number" min="0.001" max="5" step="0.001" placeholder="Брутто" class="col-xs-2 form-control" id="gross_'+telnum+'" name="gross_'+telnum+'" required></div></div><!-- Количество компонента НЕТТО --><div class="col-xs-2"><div class="form-group"><input type="number" min="0.001" max="5" step="0.001" placeholder="Нетто" class="col-xs-2 form-control" id="net_'+telnum+'" name="net_'+telnum+'" required></div></div><!-- Комментарий к компоненту --><div class="col-xs-3"><div class="form-group"><input type="text" placeholder="Комментарий" class="col-xs-4 form-control" id="component_comment_'+telnum+'" name="component_comment_'+telnum+'"></div></div><!-- Управляющие конструкции --><div class="col-xs-1"><div class="form-group deletebutton" onclick="deleteField('+telnum+');"><i class="fa fa-times fa" aria-hidden="true" style="color: red;"></i></div></div></div>');
    }

    function deleteField (id) {
/*        alert("id = "+id); */
        $('div#add'+id).remove();
    }

</script>
<script>
    $("form").submit(function(e) {

        var ref = $(this).find("[required]");

        $(ref).each(function(){
            if ( $(this).val() == '' )
            {
                alert("Required field should not be blank.");

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