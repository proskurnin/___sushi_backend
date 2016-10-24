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

        .diagnostika-1 {
            position: fixed;
            z-index: 1500;
            background-color: rgba(255,255,255,.9);
            top: 25px;
            right: 25px;
            width: 350px;
            padding: 15px;
            border: 1px solid #737373;
            border-radius: 10px;

        }

        .diagnostika-2 {
            position: fixed;
            z-index: 1500;
            background-color: rgba(255,255,255,.9);
            top: 25px;
            left: 25px;
            width: 800px;
            padding: 15px;
            border: 1px solid #737373;
            border-radius: 10px;
            font-size: .7rem;
        }
    </style>
</head>


<body>
<?php
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
//
//             В ЭТОМ РАЗДЕЛЕ СОБРАНЫ ВСЕ ФУНКЦИИ ИЗ ДОКУМЕНТА
//
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =


//        Строим строки с полями формы

function rowform ($i,$event,$edit_name) {
    if ($event == 'event_first') {

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
                    <select class='form-control form-control-danger' id='component_id_{$i}' name='component_id_{$i}'>
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
    if ($event == 'event_edit') {

        $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
        $mysqli->query("SET NAMES 'utf8'");

        $db_components = $mysqli->query("SELECT  `product_id` FROM  `recipes` WHERE  `recipe_name` =  '$edit_name'") or die();
        while (($db_element_component = $db_components->fetch_assoc()) != false)
        {
            $element_component_db[] = array_shift($db_element_component);
        }
        $db_gross = $mysqli->query("SELECT  `product_gross` FROM  `recipes` WHERE  `recipe_name` =  '$edit_name'") or die();
        while (($db_element_gross = $db_gross->fetch_assoc()) != false)
        {
            $element_gross_db[] = array_shift($db_element_gross);
        }
        $db_net = $mysqli->query("SELECT  `product_net` FROM  `recipes` WHERE  `recipe_name` =  '$edit_name'") or die();
        while (($db_element_net = $db_net->fetch_assoc()) != false)
        {
            $element_net_db[] = array_shift($db_element_net);
        }
        $db_comment = $mysqli->query("SELECT  `component_comment` FROM  `recipes` WHERE  `recipe_name` =  '$edit_name'") or die();
        while (($db_element_comment = $db_comment->fetch_assoc()) != false)
        {
            $element_comment_db[] = array_shift($db_element_comment);
        }
        $j = $i - 1;


//    ДИАГНОСТИКА
//
//        echo 'шаг номер '.$i.'<br>';
//        echo '<b>$element_component['.$j.'] = '.$element_component[$j].'</b><br>';
//        echo '<b>$element_gross['.$j.'] = '.$element_gross[$j].'</b><br>';
//        echo '<b>$element_net['.$j.'] = '.$element_net[$j].'</b><br>';
//        echo '<b>$element_comment['.$j.'] = '.$element_comment[$j].'</b><br>';
//        echo '<br>';
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
            if ($element_gross_db[$j] == '0' || $element_gross_db[$j] == '') {
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
                            <input type='text' value='".$element_gross_db[$j]."' class='col-xs-3 form-control form-control-warning' id='gross_{$i}' name='gross_{$i}'>
                        </div>
                    </div>
                </div>
                ";
            }

            // Формируем элемент НЕТТО
            if ($element_net_db[$j] == '0' || $element_net_db[$j] == '') {
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
                            <input type='text' value='".$element_net_db[$j]."' class='col-xs-3 form-control form-control-warning' id='net_{$i}' name='net_{$i}'>
                        </div>
                    </div>
                </div>
                ";
            }

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
                echo "
                    <tr>
                    <td>" . $npp . "</td>
                    <td>" . $recipe_name . "</td>
                    <td>" . $recipe_amount . "</td>
                    <td>" . $recipe_cost . "</td>
                    <td>" . $recipe_protein . "</td>
                    <td>" . $recipe_fat . "</td>
                    <td>" . $recipe_carbohydrate . "</td>
                    <td>" . $recipe_energy . "</td>
                    <td>
                    <a name='del' href=".$urlform."?del=".urlencode($recipe_name).">
                    <i class='fa fa-times' aria-hidden='true' style='color: red;'></i>
                    </a>
            
                    &nbsp;&nbsp;&nbsp;
            
                    <a name='edit' href=".$urlform."?editrow=editrow&edit_name=".urlencode($recipe_name).">
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
        echo "
            <tr>
            <td>" . $npp . "</td>
            <td>" . $recipe_name . "</td>
            <td>" . $recipe_amount . "</td>
            <td>" . $recipe_cost . "</td>
            <td>" . $recipe_protein . "</td>
            <td>" . $recipe_fat . "</td>
            <td>" . $recipe_carbohydrate . "</td>
            <td>" . $recipe_energy . "</td>
            <td>
            <a name='del' href=".$urlform."?del=".urlencode($recipe_name).">
            <i class='fa fa-times fa' aria-hidden='true' style='color: red;'></i>
            </a>
    
            &nbsp;&nbsp;&nbsp;
    
            <a name='edit' href=".$urlform."?editrow=editrow&edit_name=".urlencode($recipe_name).">
            <i class='fa fa-pencil-square-o fa' aria-hidden='true' style='color: cornflowerblue;'></i>
            </a>
            </td>
            </tr>";
    }

    $mysqli->close();
}


//                Строим таблицу
//                   ПРОСМОТР

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
                echo "
                    <tr>
                    <td>" . $npp . "</td>
                    <td>" . $recipe_name . "</td>
                    <td>" . $recipe_amount . "</td>
                    <td>" . $recipe_cost . "</td>
                    <td>" . $recipe_protein . "</td>
                    <td>" . $recipe_fat . "</td>
                    <td>" . $recipe_carbohydrate . "</td>
                    <td>" . $recipe_energy . "</td>
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
        echo "
            <tr>
            <td>" . $npp . "</td>
            <td>" . $recipe_name . "</td>
            <td>" . $recipe_amount . "</td>
            <td>" . $recipe_cost . "</td>
            <td>" . $recipe_protein . "</td>
            <td>" . $recipe_fat . "</td>
            <td>" . $recipe_carbohydrate . "</td>
            <td>" . $recipe_energy . "</td>
        </tr>";
    }
    $mysqli->close();
}


//    Функция удаления данных из таблицы recipеs

function rowdelete ($del) {
    $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
    $mysqli->query("SET NAMES 'utf8'");
    $query = "DELETE FROM `recipes` WHERE `recipe_name` = '$del'";
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

function rowscounter ($row_name){
    $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
    $mysqli->query("SET NAMES 'utf8'");
    $query = "SELECT  `product_id` FROM  `recipes` WHERE  `recipe_name` =  '$row_name'";
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
// Адрес страницы во всех формах
$urlform = 'dish.php';
// Удаление данных из таблицы recipеs
if(isset($_GET['del']))
{
    $del = $_GET['del'];
    rowdelete($del);
}



// Установка $edit_name для редактирования

if (isset($_GET['edit_name'])) {
    $edit_name = $_GET['edit_name'];
}
else if (isset($_POST['edit_name'])) {
    $edit_name = $_POST['edit_name'];
}
else {
    $edit_name = -1;
}

// и $name для отображения в поле Название рецепта
if (isset($_GET['add_name'])) {
    $name = $_GET['add_name'];
}
else if (isset($_POST['add_name'])) {
    $name = $_POST['add_name'];
}
else if (isset($_GET['add_name_edit'])) {
    $name = $_GET['add_name_edit'];
}
else if (isset($_POST['add_name_edit'])) {
    $name = $_POST['add_name_edit'];
}
else if (isset($_GET['edit_name'])) {
    $name = $_GET['edit_name'];
}
else if (isset($_POST['edit_name'])) {
    $name = $_POST['edit_name'];
}
else {
    $name = -1;
}

$add_name = $_POST['add_name'];


// Устанавливаем число строк формы
// На первом шагу определяем количество строк, которые используются в рецепте для редактирования
if (isset($_GET['edit_name']) || isset($_POST['edit_name'])) {
    $num_rows = rowscounter($edit_name);
}
// Второй и третий шаг установка количества строк если параметр передан очевидно
else if ($_POST['num_rows'] > 0) {
    $num_rows = $_POST['num_rows'];
}
else if ($_GET['num_rows'] > 0) {
    $num_rows = $_GET['num_rows'];
}
else {
    // по умолчанию (если иное не заданно) используем 5 строк для вывода формы
    $num_rows = 5;
}


//                           Выбор режима работы ФОНА формы!
//               Варианты: серый фон - show_manag, желтый фон - shoe_edit
//                          ОШИБКА - РЕДАКТИРОВАНИЕ - ПРОСМОТР

if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow') {
    $showtype = 'show_edit';
} else  if ($_GET['showtype'] == 'show_manag' || $_POST['showtype'] == 'show_manag') {
    $showtype = 'show_manag';
} else {
    $showtype = 'show_no';
}


//                           Выбор режима работы ПОЛЕЙ формы!
//   Варианты: красные и серые поля - event_mistake, желтые поля - event_edit, серые поля - event_first
//                          ОШИБКА - РЕДАКТИРОВАНИЕ - ПРОСМОТР


if ($_GET['editrow'] == 'editrow' || $_POST['editrow'] == 'editrow') {
    $event = 'event_edit';
}
else if ($error == 1) {
    $event = 'event_mistake';
}
else {
    $event = 'event_first';
}


//       Добавление данных в таблицу recipes
//
//        НЕ СДЕЛАЛ ВООБЩЕ ПОЛУФАБРИКАТЫ !!!
//
if ($_POST['actiontype'] == 'add' || $_POST['actiontype'] == 'edit')
{

//    if (isset($_POST['recipe_name']))
//    {
//        $add_name = $_POST['add_name'];
//    }
//    else
//    {
//        $add_name = $edit_name;
//    }



// Обработчик ошибок - поиск незаполненных полей
    $error = 0;
    $dubl = 0;
    $num_rows_validator = 0;


    $query = "SELECT `recipe_name` FROM `recipes`";
    $db_names = $mysqli->query($query) or die($query);
    while (($db_recipes_names = $db_names->fetch_assoc()) != false)
    {
        if ($add_name == $db_recipes_names['recipe_name']) {
            $error = 1;
            $dubl = 1;
            $reason = $reason.'Название рецепта уже используется!\u000A';
            break;
        }
    }

    if(isset($_POST['add_name_edit'])) {
        $add_name = $_POST['add_name_edit'];
        $_POST['add_name'] = $_POST['add_name_edit'];
    }

    if ($add_name == '')
    {
        $error = 1;
        $reason = $reason.'Не указано название рецепта!\u000A';
    }

    for ($i = 0; $i++ < $num_rows;) {
        // echo $_POST['component_id_'.$i];
        if (isset($_POST['component_id_'.$i]) && $_POST['component_id_'.$i] !== '0')
        {
            if (!isset($_POST['gross_'.$i]) || $_POST['gross_'.$i] == '0' || $_POST['gross_'.$i] == '')
            {
                // echo $_POST['component_id_'.$i];
                $error = 1;
                $reason = $reason.'В строке '.$i.' не указан вес Брутто! (компонент указан)\u000A';
            }
            if (!isset($_POST['net_'.$i]) || $_POST['net_'.$i] == '0' || $_POST['net_'.$i] == '')
            {
                // echo $_POST['net_'.$i];
                $error = 1;
                $reason = $reason.'В строке '.$i.' не указан вес Нетто! (компонент указан)\u000A';
            }
            $names_arr[] = $_POST['component_id_'.$i];
            $num_rows_validator++;
        }
        else if ($_POST['gross_'.$i] > 0)
        {
            if (!isset($_POST['component_id_'.$i]) || $_POST['component_id_'.$i] == '0' || $_POST['component_id_'.$i] == '')
            {
                // echo $_POST['component_id_'.$i];
                $error = 1;
                $reason = $reason.'В строке '.$i.' не указан Компонент! (вес брутто указан)\u000A';
            }
            if (!isset($_POST['net_'.$i]) || $_POST['net_'.$i] == '0' || $_POST['net_'.$i] == '')
            {
                // echo $_POST['net_'.$i];
                $error = 1;
                $reason = $reason.'В строке '.$i.' не указан вес Нетто! (вес брутто указан)\u000A';
            }
            $num_rows_validator++;
        }
        else if ($_POST['net_'.$i] > 0)
        {
            if (!isset($_POST['component_id_'.$i]) || $_POST['component_id_'.$i] == '0' || $_POST['component_id_'.$i] == '')
            {
                // echo $_POST['component_id_'.$i];
                $error = 1;
                $reason = $reason.'В строке '.$i.' не указан Компонент! (вес нетто указан)\u000A';
            }
            if (!isset($_POST['gross_'.$i]) || $_POST['gross_'.$i] == '0' || $_POST['gross_'.$i] == '')
            {
                // echo $_POST['gross_'.$i];
                $error = 1;
                $reason = $reason.'В строке '.$i.' не указан вес Брутто! (вес нетто указан)\u000A';
            }
            $num_rows_validator++;
        }
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
    }

    $names_arr = array_count_values($names_arr);
    foreach($names_arr as $kk=>$vv) {
        if ($vv > 1) {
            $error = 1;
            $reason = $reason.'Дублируются компоненты!\u000A';
            break;
        }
    }

    $num_rows = $num_rows_validator;

// Если мы выявили ошибку, значит переменная "событий" приняла значение "ошибка"
    if ($error == 1) $event = 'event_mistake';



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

        $num_rows = rowscounter($edit_name);
//        $add_name = $edit_name;

        $db_components = $mysqli->query("SELECT  `recipe_id` FROM  `recipes` WHERE  `recipe_name` =  '$edit_name'") or die();
        while (($db_element_component = $db_components->fetch_assoc()) != false)
        {
            $recipe_id_arr[] = $db_element_component['recipe_id'];
        }


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



        for ($i = 0; $i++ < $num_rows;) {
            $j = $i - 1;

            $recipe_id = $recipe_id_arr[$j];
            $product_id = $_POST['component_id_'.$i];
// НУЖНО СДЕЛАТЬ
// Если переменная $product_id содержит product_ значить заполняем раздел product (продукты)
// если же переменная $product_id содержит semi_ значить заполняем раздел semi (полуфабрикаты)
//            if ()
            $product_id = trim($product_id, 'product_');
            $product_gross = $_POST['gross_'.$i];
            $product_net = $_POST['net_'.$i];
// ПОЛУФАБРИКАТЫ ДОБАВИТЬ ПОЗЖЕ !!! а пока пустое значение
            $semi_id = '0';
            $semi_gross = '0';
            $semi_net = '0';
// ПОЗЖЕ !!! а пока пустое значение
            $component_comment = $_POST['component_comment_'.$i];




//     Диагностика данных, которые мы вносим!
//           Блок разделён на три части
//             Это блок №2 - "данные"

            echo '<b>Обработка строки: '.$i.'<br></b>';
            echo 'ID строки рецепта: <span style="color: red;">'.$recipe_id.'</span> <b>||</b> ';
            echo 'ID компонента: <span style="color: red;">'.$product_id.'</span> <b>||</b> ';
            echo 'Вес Брутто: <span style="color: red;">'.$product_gross.'</span> <b>||</b> ';
            echo 'Вес Нетто: <span style="color: red;">'.$product_net.'</span> <b>||</b> ';
            echo 'Полуфабрикаты (не сделано): <span style="color: red;">'.$semi_id.', ';
            echo $semi_gross.', ';
            echo $semi_net.'</span> <b>||</b> ';
            echo 'Комментарий: <span style="color: red;">'.$component_comment.'</span><br><br>';

            $query = "UPDATE `recipes`
                      SET                              
                      `recipe_name` = '$add_name',
                      `product_id` = '$product_id',
                      `product_gross` = '$product_gross',
                      `product_net` = '$product_net',
                      `semi_id` = '$semi_id',
                      `semi_gross` = '$semi_gross',
                      `semi_net` = '$semi_net',
                      `component_comment` = '$component_comment'
                      WHERE  
                      `recipe_id` = '$recipe_id'";
            /* Выполняем запрос. Если произойдет ошибка - вывести ее. */
            $mysqli->query($query) or die($query);

        }



//     Диагностика данных, которые мы вносим!
//           Блок разделён на три части
//             Это блок №3 - "футер"
                 echo '</div>';
//                НЕ ИСПОЛЬЗУЕМ
//     потому что не влезает по высоте на экран




    }
// Добаление данных в Базу Данных
// Работает хорошо
    else if($_POST['actiontype'] == 'add')
    {


//     Диагностика данных, которые мы вносим!
//           Блок разделён на три части
//             Это блок №1 - "хидер"
        echo '<div class="diagnostika-2">';
//                 НЕ ИСПОЛЬЗУЕМ
//     потому что не влезает по высоте на экран

        echo "<h2>Hi NEW RECIPE!</h2>";
        echo 'Вносим: <span style="color: red;">'.$add_name.'</span><br>';
        echo 'Количество строк: <span style="color: red;">'.$num_rows_validator.'</span><br><br>';



        for ($i = 0; $i++ < $num_rows;) {


            $product_id = $_POST['component_id_'.$i];
// НУЖНО СДЕЛАТЬ
// Если переменная $product_id содержит product_ значить заполняем раздел product (продукты)
// если же переменная $product_id содержит semi_ значить заполняем раздел semi (полуфабрикаты)
//            if ()
            $product_id = trim($product_id, 'product_');
            $product_gross = $_POST['gross_'.$i];
            $product_net = $_POST['net_'.$i];
// ПОЛУФАБРИКАТЫ ДОБАВИТЬ ПОЗЖЕ !!! а пока пустое значение
            $semi_id = '0';
            $semi_gross = '0';
            $semi_net = '0';
// ПОЗЖЕ !!! а пока пустое значение
            $component_comment = $_POST['component_comment_'.$i];



//     Диагностика данных, которые мы вносим!
//           Блок разделён на три части
//             Это блок №2 - "данные"


            echo '<b>Обработка строки: '.$i.'<br></b>';
            echo 'ID компонента: <span style="color: red;">'.$product_id.'</span> <b>||</b> ';
            echo 'Вес Брутто: <span style="color: red;">'.$product_gross.'</span> <b>||</b> ';
            echo 'Вес Нетто: <span style="color: red;">'.$product_net.'</span> <b>||</b> ';
            echo 'Полуфабрикаты (не сделано): <span style="color: red;">'.$semi_id.', ';
            echo $semi_gross.', ';
            echo $semi_net.'</span> <b>||</b> ';
            echo 'Комментарий: <span style="color: red;">'.$component_comment.'</span><br><br>';



            $query = "INSERT INTO `recipes`
            (`recipe_id`,`recipe_name`,`product_id`,`product_gross`,`product_net`,`semi_id`,`semi_gross`,`semi_net`,`component_comment`)
            VALUES  (NULL,'$add_name','$product_id','$product_gross','$product_net','$semi_id','$semi_gross','$semi_net','$component_comment')";
            /* Выполняем запрос. Если произойдет ошибка - вывести ее. */
            $mysqli->query($query) or die($query);
        }



//     Диагностика данных, которые мы вносим!
//           Блок разделён на три части
//             Это блок №3 - "футер"
                 echo '</div>';
//                НЕ ИСПОЛЬЗУЕМ
//     потому что не влезает по высоте на экран




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


        echo "<h1 class='display-1'>Сеты</h1>";


        ?>
        <br>

<!--      Блок с кнопками навигации по заполнению данных в меню       -->
<!-- Должна отображаться структура наполнения от Полуфабриката к Сету -->

        <div>
            <a href="semi.php" class="btn btn-outline-info">Полуфабрикаты</a>
            <a href="preset.php" class="btn btn-outline-primary">Комплекты</a>
            <a href="recipe.php" class="btn btn-outline-success">Рецепты</a>
            <a href="dish.php" class="btn btn-outline-warning">Блюда</a>
            <a href="set.php" class="btn btn-danger">Сеты</a>
        </div>

        <br>

        <?php



// Данные с диагностикой. Отображаются в правом верхнем углу.

        echo '<div class="diagnostika-1">';
        echo '$event = <span style="color: red;">'.$event.'</span><br>';
        echo '$showtype = <span style="color: red;">'.$showtype.'</span><br>';
        echo '$name = <span style="color: red;">'.$name.'</span><br>';
        echo '$add_name = <span style="color: red;">'.$add_name.'</span><br>';
        echo '$add_name_edit = <span style="color: red;">'.$add_name_edit.'</span><br>';
        echo '$edit_name = <span style="color: red;">'.$edit_name.'</span><br>';
        echo '$num_rows = <span style="color: red;">'.$num_rows.'</span><br>';

        echo '<br>';
        echo '$_POST[add_name_edit] = <span style="color: red;">'.$_POST[add_name_edit].'</span><br>';
        echo '$_POST[showtype] = <span style="color: red;">'.$_POST[showtype].'</span><br>';
        echo '$_POST[actiontype] = <span style="color: red;">'.$_POST[actiontype].'</span><br>';
    // Дублированная строка. Выше уже выводим переменную $num_rows
        echo '$_POST[num_rows] = <span style="color: red;">'.$_POST[num_rows].'</span><br>';
        echo '</div>';



// Строим форму со строками на количество которых влияет переменная $num_rows
//             и таблицу с данными для редактирвоания


        if ($showtype !== 'show_no' || isset($_GET['del']) || isset($_GET['edit_name']))
        {
            // ФОРМА работы с данными
            // Заголовок поля формы добавления и редактирования данных
            if ($showtype == 'show_edit' || ($error == 1 && $showtype == 'show_manag'))
            {
                echo "<h4>Редактирование рецепта ".$edit_name."</h4>";
                echo "<div class='editform'>";
            }
            else
            {
                echo "<h4>Добавление нового рецепта</h4>";
                echo "<div class='addform'>";
            }
            // КОНЕЦ Заголовка формы

    echo "
    <form action='".$urlform."' class='form-horizontal' method='post'>
        <div class='container'>
        <!-- Название рецепта -->
            <div class='form-group row'>";
            echo "<div class='col-xs-12'>";
            // Отображение для редактирования
            if ($event == 'event_edit')
            {
                echo "<div class='form-group has-warning'>";
                echo "<input type='text' value='".$name."' class='col-xs-3 form-control form-control-warning' id='add_name_edit' name='add_name_edit'>";
                echo "</div>";
            }
            // Отображение ПЕРВОГО внесения данных
            else if ($event == 'event_first')
            {
                echo "<div class='form-group'>";
                echo "<input type='text' placeholder='Название рецепта' class='col-xs-3 form-control' id='add_name' name='add_name'>";
                echo "</div>";
            }
            // Отображение если данные не указаны для добавления или изменения
            else if (!isset($_POST['add_name']) || $_POST['add_name'] == '0' || $_POST['add_name'] == '' || $dubl == 1)
            {
                echo "<div class='form-group has-danger'>";
                echo "<input type='text' placeholder='Название рецепта' class='col-xs-3 form-control form-control-danger' id='add_name' name='add_name'>";
                echo "</div>";
            }
            // Отображение данных, когда все указано ВЕРНО
            else
            {
                echo "<div class='form-group has-success'>";
                echo "<input type='text' value='".$name."' class='col-xs-3 form-control form-control-success' id='add_name' name='add_name'>";
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";

// Вывод строк для внесения в них данных!
            for ($i=0; $i++ < $num_rows;) echo rowform($i,$event,$edit_name);



            echo "<div class='form-group row'>";
            // Кнопки [Внести изменения] и [Добавить]
            echo "<div class='col-xs-12'>";


            // Отображение для редактирования
            if ($showtype == 'show_edit' || ($error == 1 && $showtype == 'show_manag'))
            {


//
// Нужно подумать как сделать так, чтобы при неудачном изменении индикация ошибок велась
// на жёлтых полях радактирвоания

                echo "<input type='hidden' name='num_rows' value='".$num_rows."'>";
                echo "<input type='hidden' name='showtype' value='show_manag'>";
                echo "<input type='hidden' name='actiontype' value='edit'>";
                echo "<input type='hidden' name='edit_name' value='".$name."'>";
                echo "<button type='submit' name='edititem' class='btn btn-outline-warning pull-right'>Внести изменение</button>";
            }
            // Отображение ПЕРВОГО внесения данных
            else
            {
//
                echo "<input type='hidden' name='num_rows' value='".$num_rows."'>";
                echo "<input type='hidden' name='showtype' value='show_manag'>";
                echo "<input type='hidden' name='actiontype' value='add'>";
                echo "<button type='submit' name='addnewitem' class='btn btn-outline-primary pull-right'>Добавить рецепт</button>";
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

            // Создаём массив для работы с ним
            $recipes_result_set = $mysqli->query("SELECT * FROM `recipes`");
            echo editTable ($recipes_result_set);


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
            $recipes_result_set = $mysqli->query("SELECT * FROM `recipes`");
            // Наполняем таблицу строками
            echo showTable ($recipes_result_set);

            echo "
                </tbody>
            </table>
		
	    <br>
            <form action='".$urlform."' method='post' class='form-inline'>
                <input type='password' placeholder='Пароль для редактирования' class='form-control' id='passforedit' name='passforedit' size='20'>
				<label for='num_rows'>Строк для добавления: </label>
                <input type='number' value='5' class='form-control' id='num_rows' name='num_rows' min='1' max='20' size='5'>
                
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