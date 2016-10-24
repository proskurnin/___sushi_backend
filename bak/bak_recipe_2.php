<!DOCTYPE html>
<html lang="ru">
<?php


// Адрес страницы во всех формах
$urlform = 'recipe.php';
// Название таблицы БД, с которой работаем, добавляется в конце s. Имеем имяs
// Поле имя в данной таблице обызательно имя_name
// Поле id, если нужно, имеет вид имя_id. Связи таблиц решил делать через name. Нужно чтобы было уникальным.
$tabname = 'recipe';

// Пароль на редактирование данной страницы
$password = '11';
// Включение ДИАГНОСТИКИ переменных (on/off)
$diagnostics_var = 'off';
// Включение ДИАГНОСТИКИ событий (on/off)
$diagnostics_event = 'off';
// Включение ДИАГНОСТИКИ переключения пищевой ценности (on/off)
$diagnostics_tab = 'off';


?>
<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Полуфабрикаты - Рецепты - Блюда - Сеты</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="sha384-MIwDKRSSImVFAZCVLtU0LMDdON6KVCrZHyVQQj6e8wIEJkW4tvwqXrbMIya1vriY" crossorigin="anonymous">

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

    if ($event == 'event_first') {

        $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
        $mysqli->query("SET NAMES 'utf8'");


// Строим выпадающий список полуфабрикатов. Выбор полуфабрикатов в списке по NAME
        $options_semis = '';
        $query = "SELECT * FROM `semis` ORDER BY semi_name";
        $selsemis = $mysqli->query($query) or die($query);
        $semi_name_check = '';
        while (($optsemis = $selsemis->fetch_assoc()) != false)
        {
            $semi_name = $optsemis['semi_name'];

            foreach ($optsemis as $k => $v) {

                if ($semi_name !== $semi_name_check) {
                    $options_semis = $options_semis."<option value='".$optsemis['semi_name']."'>".$optsemis['semi_name']."</option>";
                }
                $semi_name_check = $optsemis['semi_name'];
            }
        }

// Строим выпадающий список продуктов. Выбор продуктов в списке по NAME
        $options_products = '';
        $query = "SELECT * FROM `products` ORDER BY product_name";
        $selproduct = $mysqli->query($query) or die($query);
        while (($optproduct = $selproduct->fetch_assoc()) != false)
        {
            $options_products = $options_products.'<option value="'.$optproduct['product_name'].'">'.$optproduct['product_name'].'</option>';
        }
        $mysqli->close();

        $rowOfComponent = "
                    
                    <div id='add$i' class='add row'>
        
                    <!-- Компонент рецепта -->
                        <div class='col-xs-4'>
                            <div class='form-group'>
                            <select class='form-control' id='component_name_{$i}' name='component_name_{$i}' required>
                                    <option value=''>Выберите компонент №{$i}</option>
                                    <option value='0'>- не использовать -</option>
                                    <optgroup label='Полуфабрикаты'>
                                        {$options_semis}
                                    </optgroup>
                                    <optgroup label='Сырьё и упаковка'>
                                        {$options_products}
                                    </optgroup>
                            </select>
                            </div>
                        </div>
            
            
                    <!-- Количество компонента БРУТТО -->
                        <div class='col-xs-2'>
                            <div class='form-group'>              
                                <input type='number' min='0.001' max='5.000' step='0.00001' size='8' pattern='\d+(,\d{3})?' placeholder='Брутто' class='col-xs-2 form-control' id='gross_{$i}' name='gross_{$i}' required>
                            </div>
                        </div>
            
            
                    <!-- Количество компонента НЕТТО -->
                        <div class='col-xs-2'>
                            <div class='form-group'>
                                <input type='number' min='0.001' max='5.000' step='0.00001' size='8' pattern='\d+(,\d{3})?' placeholder='Нетто' class='col-xs-2 form-control' id='net_{$i}' name='net_{$i}' required>
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
// Сейачс не понятно по какому поваду может возникнуть ошибка?
// Не учёл вариант если совпадают имена новой позиции и совпадение ингредиентов
    if ($event == 'event_mistake') {

//        if (
//            (!isset($_POST['component_id_'.$i]) || $_POST['component_id_'.$i] == '0' || $_POST['component_id_'.$i] == '') &&
//            (!isset($_POST['gross_'.$i]) || $_POST['gross_'.$i] == '0' || $_POST['gross_'.$i] == '') &&
//            (!isset($_POST['net_'.$i]) || $_POST['net_'.$i] == '0' || $_POST['net_'.$i] == '') &&
//            (!isset($_POST['component_comment_'.$i]) || $_POST['component_comment_'.$i] == '0' || $_POST['component_comment_'.$i] == '')
//        )
//
//       {} else {


        $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
        $mysqli->query("SET NAMES 'utf8'");


        $select_option = $_POST['component_name_'.$i];


// Строим выпадающий список полуфабрикатов. Выбор полуфабрикатов в списке по NAME
        $options_semis = '';
        $query = "SELECT * FROM `semis` ORDER BY semi_name";
        $selsemis = $mysqli->query($query) or die($query);
        $semi_name_check = '';
        while (($optsemis = $selsemis->fetch_assoc()) != false)
        {
            $semi_name = $optsemis['semi_name'];

            foreach ($optsemis as $k => $v) {

                if ($semi_name !== $semi_name_check) {
                    $options_semis = $options_semis."<option value='".$optsemis['semi_name']."'>".$optsemis['semi_name']."</option>";
                }
                $semi_name_check = $optsemis['semi_name'];
            }
        }

// Строим выпадающий список продуктов. Выбор продуктов в списке по NAME
        $options_products = '';
        $query = "SELECT * FROM `products` ORDER BY product_name";
        $selproduct = $mysqli->query($query) or die($query);
        while (($optproduct = $selproduct->fetch_assoc()) != false)
        {
            $options_products = $options_products.'<option value="'.$optproduct['product_name'].'">'.$optproduct['product_name'].'</option>';
        }
        $mysqli->close();



        $element_component = '';
        $element_gross = '';
        $element_net = '';
        $element_comment = '';


        // Формируем элемент КОМПОНЕНТ
        if ($_POST['component_name_'.$i] == '0' || $_POST['component_name_'.$i] == '') {
            $element_component = "
                <div class='col-xs-4'>
                    <div class='form-group has-danger'>
                    <select class='form-control form-control-danger' id='component_name_{$i}' name='component_name_{$i}' required>
                        <option value=''>Не указано!</option>
                        <option value='0'>- не использовать -</option>
                        <optgroup label='Полуфабрикаты'>
                            {$options_semis}
                        </optgroup>
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
                    <div class='form-group has-success'>
                    <select class='form-control form-control-success' id='component_name_{$i}' name='component_name_{$i}' required>
                        <option value='{$select_option}'>{$select_option}</option>
                        <option value='0'>- не использовать -</option>
                        <optgroup label='Полуфабрикаты'>
                            {$options_semis}
                        </optgroup>
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
                <div class='form-group has-success'>
                    <div class='input-group'>
                        <input type='number' min='0.001' max='5.000' step='0.00001' size='8' pattern='\d+(,\d{3})?' value='".$_POST['gross_'.$i]."' class='col-xs-3 form-control form-control-success' id='gross_{$i}' name='gross_{$i}' required>
                    </div>
                </div>
            </div>
            ";


        // Формируем элемент НЕТТО
        $element_net = "
            <div class='col-xs-2'>
                <div class='form-group has-success'>
                    <div class='input-group'>
                        <input type='number' min='0.001' max='5.000' step='0.00001' size='8' pattern='\d+(,\d{3})?' value='".$_POST['net_'.$i]."' class='col-xs-3 form-control form-control-success' id='net_{$i}' name='net_{$i}' required>
                    </div>
                </div>
            </div>
            ";

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
            
            <div id='add$i' class='add row'>
            
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
                    <div class='form-group deletebutton' onclick='deleteField({$i});'>
                        <i class='fa fa-times fa' aria-hidden='true' style='color: red; cursor: pointer'></i>
                    </div>
                </div>
            </div>
            ";
//        }
    }
    if ($event == 'event_edit') {

        $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
        $mysqli->query("SET NAMES 'utf8'");


        $query = "SELECT  `component_name` FROM  `{$tabname}s` WHERE  `{$tabname}_name` =  '$edit_name'";
        $db_components = $mysqli->query($query) or die($query);
        while (($db_element_component = $db_components->fetch_assoc()) != false)
        {
            $element_component_db[] = array_shift($db_element_component);
        }

        $query = "SELECT  `component_gross` FROM  `{$tabname}s` WHERE  `{$tabname}_name` =  '$edit_name'";
        $db_gross = $mysqli->query($query) or die($query);
        while (($db_element_gross = $db_gross->fetch_assoc()) != false)
        {
            $element_gross_db[] = array_shift($db_element_gross);
        }

        $query = "SELECT  `component_net` FROM  `{$tabname}s` WHERE  `{$tabname}_name` =  '$edit_name'";
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



// Строим выпадающий список полуфабрикатов. Выбор полуфабрикатов в списке по NAME
        $options_semis = '';
        $query = "SELECT * FROM `semis` ORDER BY semi_name";
        $selsemis = $mysqli->query($query) or die($query);
        $semi_name_check = '';
        while (($optsemis = $selsemis->fetch_assoc()) != false)
        {
            $semi_name = $optsemis['semi_name'];

            foreach ($optsemis as $k => $v) {

                if ($semi_name !== $semi_name_check) {
                    $options_semis = $options_semis."<option value='".$optsemis['semi_name']."'>".$optsemis['semi_name']."</option>";
                }
                $semi_name_check = $optsemis['semi_name'];
            }
        }

// Строим выпадающий список продуктов. Выбор продуктов в списке по NAME
        $options_products = '';
        $query = "SELECT * FROM `products` ORDER BY product_name";
        $selproduct = $mysqli->query($query) or die($query);
        while (($optproduct = $selproduct->fetch_assoc()) != false)
        {
            $options_products = $options_products.'<option value="'.$optproduct['product_name'].'">'.$optproduct['product_name'].'</option>';
        }
        $mysqli->close();


//    ДИАГНОСТИКА
//
//        echo 'шаг номер '.$i.'<br>';
//        echo '<b>$element_component_db['.$j.'] = '.$element_component_db[$j].'</b><br>';
//        echo '<b>$element_gross_db['.$j.'] = '.$element_gross_db[$j].'</b><br>';
//        echo '<b>$element_net_db['.$j.'] = '.$element_net_db[$j].'</b><br>';
//        echo '<b>$element_comment_db['.$j.'] = '.$element_comment_db[$j].'</b><br>';
//        echo '<br>';
//
//    КОНЕЦ ДИАГНОСТИКИ




// Данное условие считаю избыточным. Раз мы в этот раздел уже попали, значит нужно строить поля.
// Ниже закомментировал ещё одну фигурную скобку закрытия этого условия.
//        if (
//            (!isset($_POST['component_id_'.$i]) || $_POST['component_id_'.$i] == '0' || $_POST['component_id_'.$i] == '') &&
//            (!isset($_POST['gross_'.$i]) || $_POST['gross_'.$i] == '0' || $_POST['gross_'.$i] == '') &&
//            (!isset($_POST['net_'.$i]) || $_POST['net_'.$i] == '0' || $_POST['net_'.$i] == '') &&
//            (!isset($_POST['component_comment_'.$i]) || $_POST['component_comment_'.$i] == '0' || $_POST['component_comment_'.$i] == '')
//        )
//
//        {



        // Формируем элемент КОМПОНЕНТ
        if ($element_component_db[$j] == '0' || $element_component_db[$j] == '') {
            $element_component = "
            <div class='col-xs-4'>
                <div class='form-group'>
                <select class='form-control' id='component_name_{$i}' name='component_name_{$i}' required>
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
                <select class='form-control form-control-warning' id='component_name_{$i}' name='component_name_{$i}' required>
                    <option value='".$element_component_db[$j]."'>".$element_component_db[$j]."</option>
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
                    <input type='number' min='0.001' max='5.000' step='0.00001' size='8' pattern='\d+(,\d{3})?' value='".$element_gross_db[$j]."' class='col-xs-3 form-control form-control-warning' id='gross_{$i}' name='gross_{$i}' required>
                </div>
            </div>
        </div>
        ";


        // Формируем элемент НЕТТО
        $element_net = "
        <div class='col-xs-2'>
            <div class='form-group has-warning'>
                <div class='input-group'>
                    <input type='number' min='0.001 ' max='5.000' step='0.00001' size='8' pattern='\d+(,\d{3})?' value='".$element_net_db[$j]."' class='col-xs-3 form-control form-control-warning' id='net_{$i}' name='net_{$i}' required>
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
        
        <div id='add$i' class='add row'>
        
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
                <div class='form-group deletebutton' onclick='deleteField({$i});'>
                    <i class='fa fa-times fa' aria-hidden='true' style='color: red; cursor: pointer'></i>
                </div>
            </div>
        </div>
        ";

//        } Закомментировал закрытие условия, которое считаю избыточным
    }

    return $rowOfComponent;
}




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
            
        if ($diagnostics_tab == 'on') {
//     Диагностика данных о подсчёте пищевой ценности!
            if ($item_name_check !== $row[$tabname . '_name']) {
                echo "<br>";
                echo "<h2>" . $row[$tabname . '_name'] . "</h2>";
            }
        }

        if ($item_name_check !== $row[$tabname.'_name'])
        {
            if ($npp !== 0)
            {
                $item_amount = $semi_item_amount + $prod_item_amount;
                $item_cost = $semi_item_cost + $prod_item_cost;
                $item_protein = $semi_item_protein + $prod_item_protein;
                $item_fat = $semi_item_fat + $prod_item_fat;
                $item_carbohydrate = $semi_item_carbohydrate + $prod_item_carbohydrate;
                $item_energy = $semi_item_energy + $prod_item_energy;

                if ($nutr_val == '1') {$nutr = $item_amount / 0.1;} else {$nutr = 1;}

                $item_protein = $item_protein / $nutr;
                $item_fat = $item_fat / $nutr;
                $item_carbohydrate = $item_carbohydrate / $nutr;
                $item_energy = $item_energy / $nutr;

                echo "
                    <tr>
                    <td>" . $npp . "</td>
                    <td>" . $item_name . "</td>
                    <td class='td-right'>" . number_format($item_amount, 3, ',', ' ') . "</td>
                    <td class='td-right'>" . number_format($item_cost, 2, ',', ' ') . "</td>
                    <td class='td-right'>" . number_format($item_protein, 3, ',', ' ') . "</td>
                    <td class='td-right'>" . number_format($item_fat, 3, ',', ' ') . "</td>
                    <td class='td-right'>" . number_format($item_carbohydrate, 3, ',', ' ') . "</td>
                    <td class='td-right'>" . number_format($item_energy, 3, ',', ' ') . "</td>";
                if ($edbutt == '1') {
                    echo "
                        <td class='td-right'>
                            <!-- Button trigger modal -->
                            <a name='modal' href=".$urlform."?item=".urlencode($item_name)." data-toggle='modal' data-target='#myModal'>
                            <i class='fa fa-info-circle' aria-hidden='true'></i></a>
                            
                            &nbsp;&nbsp;
                            
                            <a name='del' href=".$urlform."?del=".urlencode($item_name).">
                            <i class='fa fa-times' aria-hidden='true' style='color: red;'></i></a>
                    
                            &nbsp;&nbsp;
                    
                            <a name='edit' href=".$urlform."?editrow=editrow&edit_name=".urlencode($item_name).">
                            <i class='fa fa-pencil-square-o' aria-hidden='true' style='color: cornflowerblue;'></i></a>
                        </td>
                    ";
                }
                echo "    
                    </tr>";
            }

            $npp++;

            $item_amount = 0;
            $item_cost = 0;
            $item_protein = 0;
            $item_fat = 0;
            $item_carbohydrate = 0;
            $item_energy = 0;

            $semi_item_cost = 0;
            $semi_item_protein = 0;
            $semi_item_fat = 0;
            $semi_item_carbohydrate = 0;
            $semi_item_energy = 0;
            $semi_item_amount = 0;

            $prod_item_cost = 0;
            $prod_item_protein = 0;
            $prod_item_fat = 0;
            $prod_item_carbohydrate = 0;
            $prod_item_energy = 0;
            $prod_item_amount = 0;

//            echo "<hr style='background-color: red;'>";
//            echo "<h2 style='color: red;'>".$row[$tabname.'_name']."</h2>";
        }


        $item_name = $row[$tabname.'_name'];
        $item_name_check = $row[$tabname.'_name'];

        $query_prod = "SELECT * FROM `products` WHERE  `product_name` = '".$row['component_name']."'";
        $query_semi = "SELECT * FROM `semis` WHERE  `semi_name` = '".$row['component_name']."'";

        foreach ($row as $k => $v) {

            if (($k == $tabname.'_name') && ($v == $item_name))
            {
                $dbproduct = $mysqli->query($query_prod) or die($query_prod);
                /* определение числа рядов в выборке */
                $row_prod_cnt = mysqli_num_rows($dbproduct);
                if ($row_prod_cnt == 0)
                {
                    $dbsemi = $mysqli->query($query_semi) or die($query_semi);
                    /* определение числа рядов в выборке */
                    $row_semi_cnt = mysqli_num_rows($dbsemi);
                    if ($row_semi_cnt == 0)
                    {
                        echo "<b style='color: orange;'>".$row['component_name']."</b>";
                        echo "<b style='color: orange;'> - а что это тогда? </b><br>";
                    }
                    else
                    {
                        if ($diagnostics_tab == 'on') {
//     Диагностика данных о подсчёте пищевой ценности!
                            echo "<br>";
                            echo "<b style='color: green;'>" . $row['component_name'] . "</b>";
                            echo "<b style='color: green;'> - это полуфабрикат! </b><br>";
                            echo '<b style="color: red;">имя: </b>' . $row["component_name"] . ' : ';
                            echo '<b style="color: red;">брутто: </b>' . $row["component_gross"] . ' : ';
                            echo '<b style="color: red;">нетто: </b>' . $row["component_net"] . '<br>';
                            echo '<b style="color: blue;">Единица полуфабриката состоит из: </b><br>';
                        }

                        $s_item_amount = 0;
                        $s_item_cost = 0;
                        $s_item_protein = 0;
                        $s_item_fat = 0;
                        $s_item_carbohydrate = 0;
                        $s_item_energy = 0;


                        while (($semi_row = $dbsemi->fetch_assoc()) != false) {

                            $semi_item_name = $semi_row['semi_name'];
//                            $item_name_check = $semi_row['semi_name'];

                            $query = "SELECT * FROM `products` WHERE  `product_name` = '".$semi_row['component_name']."'";

                            foreach ($semi_row as $k => $v) {

                                if (($k == 'semi_name') && ($v == $semi_item_name))
                                {
                                    if ($diagnostics_tab == 'on') {
//     Диагностика данных о подсчёте пищевой ценности!
                                        echo '<b style="color: blue;">имя: </b>' . $semi_row["component_name"] . ' : ';
                                        echo '<b style="color: blue;">брутто: </b>' . $semi_row["component_gross"] . ' : ';
                                        echo '<b style="color: blue;">нетто: </b>' . $semi_row["component_net"] . '<br>';
                                    }

                                    $dbproduct = $mysqli->query($query) or die($query);
                                    $product = $dbproduct->fetch_assoc();

                                    $s_item_amount = $s_item_amount + $semi_row["component_net"];
                                    $s_item_cost = $s_item_cost + $semi_row["component_gross"] * $product["price_online"];
                                    $s_item_protein = $s_item_protein + $semi_row["component_net"] * $product["protein"];
                                    $s_item_fat = $s_item_fat + $semi_row["component_net"] * $product["fat"];
                                    $s_item_carbohydrate = $s_item_carbohydrate + $semi_row["component_net"] * $product["carbohydrate"];
                                    $s_item_energy = $s_item_energy + $semi_row["component_net"] * $product["energy"];

                                }

                            }
                        }

                        if ($diagnostics_tab == 'on') {
//     Диагностика данных о подсчёте пищевой ценности!
                            echo '<b style="color: #0000cd;">Показатель на еденицу полуфабриката: </b><br>';

                            echo '<b style="color: #0000cd;">цена: </b>' . number_format($s_item_cost, 2, ',', ' ') . ' : ';
                            echo '<b style="color: #0000cd;">кол: </b>' . number_format($s_item_amount, 3, ',', ' ') . ' : ';
                            echo '<b style="color: #0000cd;">белок: </b>' . number_format($s_item_protein, 3, ',', ' ') . ' : ';
                            echo '<b style="color: #0000cd;">жир: </b>' . number_format($s_item_fat, 3, ',', ' ') . ' : ';
                            echo '<b style="color: #0000cd;">углев: </b>' . number_format($s_item_carbohydrate, 3, ',', ' ') . ' : ';
                            echo '<b style="color: #0000cd;">энерг: </b>' . number_format($s_item_energy, 3, ',', ' ') . '<br>';
                        }

                        $semi_item_cost = $s_item_cost / $s_item_amount * $row["component_gross"];
                        $semi_item_protein = $s_item_protein / $s_item_amount * $row["component_net"];
                        $semi_item_fat = $s_item_fat / $s_item_amount * $row["component_net"];
                        $semi_item_carbohydrate = $s_item_carbohydrate / $s_item_amount * $row["component_net"];
                        if ($diagnostics_tab == 'on') {
//     Диагностика данных о подсчёте пищевой ценности!
                            echo '<b style="color: #cd1824;">проверка эн.ценности: </b><br>'
                                . number_format($semi_item_energy, 3, ',', ' ') .
                                ' = '
                                . number_format($s_item_energy, 3, ',', ' ') .
                                ' / '
                                . number_format($s_item_amount, 3, ',', ' ') .
                                ' * '
                                . number_format($row["component_net"], 3, ',', ' ') .
                                '<br>';
                        }
                        $semi_item_energy = $s_item_energy / $s_item_amount * $row["component_net"];
                        $semi_item_amount = $s_item_amount / $s_item_amount * $row["component_net"];

                        if ($diagnostics_tab == 'on') {
//     Диагностика данных о подсчёте пищевой ценности!
                            echo '<b style="color: #00c1cd;">Показатель эн.ценности на ' . number_format($semi_item_amount, 3, ',', ' ') . ' кг.: </b><br>';

                            echo '<b style="color: #00c1cd;">цена: </b>' . number_format($semi_item_cost, 2, ',', ' ') . ' : ';
                            echo '<b style="color: #00c1cd;">кол: </b>' . number_format($semi_item_amount, 3, ',', ' ') . ' : ';
                            echo '<b style="color: #00c1cd;">белок: </b>' . number_format($semi_item_protein, 3, ',', ' ') . ' : ';
                            echo '<b style="color: #00c1cd;">жир: </b>' . number_format($semi_item_fat, 3, ',', ' ') . ' : ';
                            echo '<b style="color: #00c1cd;">углев: </b>' . number_format($semi_item_carbohydrate, 3, ',', ' ') . ' : ';
                            echo '<b style="color: #00c1cd;">энерг: </b>' . number_format($semi_item_energy, 3, ',', ' ') . '<br>';
                        }

                    }
                }
                else
                {
                    $product = $dbproduct->fetch_assoc();

                    if ($diagnostics_tab == 'on') {
//     Диагностика данных о подсчёте пищевой ценности!
                        echo "<br>";
                        echo "<b style='color: green;'>" . $row['component_name'] . "</b>";
                        echo "<b style='color: green;'> - это продукт! </b><br>";
                        echo '<b style="color: red;">имя: </b>' . $row["component_name"] . ' : ';
                        echo '<b style="color: red;">брутто: </b>' . $row["component_gross"] . ' : ';
                        echo '<b style="color: red;">нетто: </b>' . $row["component_net"] . '<br>';
                    }

                    $prod_item_amount = $prod_item_amount + $row["component_net"];
                    $prod_item_cost = $prod_item_cost + $row["component_gross"] * $product["price_online"];
                    $prod_item_protein = $prod_item_protein + $row["component_net"] * $product["protein"] / 0.1;
                    $prod_item_fat = $prod_item_fat + $row["component_net"] * $product["fat"] / 0.1;
                    $prod_item_carbohydrate = $prod_item_carbohydrate + $row["component_net"] * $product["carbohydrate"] / 0.1;
                    $prod_item_energy = $prod_item_energy + $row["component_net"] * $product["energy"] / 0.1;

                    if ($diagnostics_tab == 'on') {
//     Диагностика данных о подсчёте пищевой ценности!
                        echo '<b style="color: #00c1cd;">цена: </b>' . number_format(($row["component_gross"] * $product["price_online"]), 2, ',', ' ') . ' ('.number_format($prod_item_cost, 2, ',', ' ').') : ';
                        echo '<b style="color: #00c1cd;">кол: </b>' . number_format(($row["component_net"]), 3, ',', ' ') . ' ('.number_format($prod_item_amount, 3, ',', ' ').') : ';
                        echo '<b style="color: #00c1cd;">белок: </b>' . number_format((($row["component_net"] * $product["protein"]) / 0.1), 3, ',', ' ') . ' ('.number_format($prod_item_protein, 3, ',', ' ').') : ';
                        echo '<b style="color: #00c1cd;">жир: </b>' . number_format((($row["component_net"] * $product["fat"]) / 0.1), 3, ',', ' ') . ' ('.number_format($prod_item_fat, 3, ',', ' ').') : ';
                        echo '<b style="color: #00c1cd;">углев: </b>' . number_format((($row["component_net"] * $product["carbohydrate"]) / 0.1), 3, ',', ' ') . ' ('.number_format($prod_item_carbohydrate, 3, ',', ' ').') : ';
                        echo '<b style="color: #00c1cd;">энерг: </b>' . number_format((($row["component_net"] * $product["energy"]) / 0.1), 3, ',', ' ') . ' ('.number_format($prod_item_energy, 3, ',', ' ').') <br>';
                    }
                }
            }
        }

    }
    if ($npp !== 0)
    {
        $item_amount = $semi_item_amount + $prod_item_amount;
        $item_cost = $semi_item_cost + $prod_item_cost;
        $item_protein = $semi_item_protein + $prod_item_protein;
        $item_fat = $semi_item_fat + $prod_item_fat;
        $item_carbohydrate = $semi_item_carbohydrate + $prod_item_carbohydrate;
        $item_energy = $semi_item_energy + $prod_item_energy;

        if ($nutr_val == '1') {$nutr = $item_amount / 0.1;} else {$nutr = 1;}

        $item_protein = $item_protein / $nutr;
        $item_fat = $item_fat / $nutr;
        $item_carbohydrate = $item_carbohydrate / $nutr;
        $item_energy = $item_energy / $nutr;

        echo "
            <tr>
            <td>" . $npp . "</td>
            <td>" . $item_name . "</td>
            <td class='td-right'>" . number_format($item_amount, 3, ',', ' ') . "</td>
            <td class='td-right'>" . number_format($item_cost, 2, ',', ' ') . "</td>
            <td class='td-right'>" . number_format($item_protein, 3, ',', ' ') . "</td>
            <td class='td-right'>" . number_format($item_fat, 3, ',', ' ') . "</td>
            <td class='td-right'>" . number_format($item_carbohydrate, 3, ',', ' ') . "</td>
            <td class='td-right'>" . number_format($item_energy, 3, ',', ' ') . "</td>";
        if ($edbutt == '1') {
            echo "
                <td class='td-right'>
                    <!-- Button trigger modal -->
                    <a name='modal' href=".$urlform."?item=".urlencode($item_name)." data-toggle='modal' data-target='#myModal'>
                    <i class='fa fa-info-circle' aria-hidden='true'></i>
                    </button>
                    
                    &nbsp;&nbsp;
                    
                    <a name='del' href=".$urlform."?del=".urlencode($item_name).">
                    <i class='fa fa-times' aria-hidden='true' style='color: red;'></i>
                    </a>
            
                    &nbsp;&nbsp;
            
                    <a name='edit' href=".$urlform."?editrow=editrow&edit_name=".urlencode($item_name).">
                    <i class='fa fa-pencil-square-o' aria-hidden='true' style='color: cornflowerblue;'></i>
                    </a>
                </td>
            ";
        }
        echo "    
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
if ($_POST['actiontype'] == 'add' || $_POST['actiontype'] == 'edit') {

//                         Начало блока
//                ЗАПОЛНЕНИЕ И РЕДАКТИРОВАНИЕ БД


// Если на предыдущем шаге выявили ошибки, в нашем случае - это пустые (не заполненные) поля строк
// В строке все поля, кроме комментария обязательные для заполнения, если заполнена хотябы одна ячейка

    if ($event == 'event_mistake')
    {

        echo "<script>alert('$reason');</script>";
    }


// Действие по редактированию через UPDATE
    else if ($_POST['actiontype'] == 'edit') {

        if (!isset($_POST['num_rows']))
        {
            $num_rows = rowscounter($edit_name,$tabname);
            $num_rows_more = 0;
        }
        else
        {
            $num_rows = $_POST['num_rows'];
            $num_rows_more = $_POST['num_rows'] - rowscounter($edit_name,$tabname);
        }
        $num_rows_corrector = $num_rows;


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
            echo 'Новых строк: <span style="color: red;">'.$num_rows_more.'</span><br>';
            echo '<hr>';
        }



        for ($i = 0; $i++ < ($num_rows - $num_rows_more);) {
            $j = $i - 1;

            $element_id = $element_id_arr[$j];
            $component_name = $_POST['component_name_'.$i];
            $component_gross = $_POST['gross_'.$i];
            $component_net = $_POST['net_'.$i];
            $component_comment = $_POST['component_comment_'.$i];


            if ($component_name == '0' || $component_gross == '0' || $component_net == '0' ||
                $component_name == '' || $component_gross == '' || $component_net == '')
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
                $num_rows_corrector--;
            }
            else
            {
                if ($diagnostics_event == 'on') {
//     Диагностика данных, которые мы вносим!
//           Блок разделён на три части
//             Это блок №2 - "данные"

                    echo '<b>Обработка строки: ' . $i . '<br></b>';
                    echo 'ID строки: <span style="color: red;">' . $element_id . '</span> <b>||</b> ';
                    echo 'Имя компонента: <span style="color: red;">' . $component_name . '</span> <b>||</b> ';
                    echo 'Вес Брутто: <span style="color: red;">' . $component_gross . '</span> <b>||</b> ';
                    echo 'Вес Нетто: <span style="color: red;">' . $component_net . '</span> <b>||</b> ';
                    echo 'Комментарий: <span style="color: red;">' . $component_comment . '</span><br><br>';

                    $query = "UPDATE `{$tabname}s`
                          SET                              
                          `{$tabname}_name` = '$add_name',
                          `component_name` = '$component_name',
                          `component_gross` = '$component_gross',
                          `component_net` = '$component_net',
                          `component_comment` = '$component_comment'
                          WHERE  
                          `{$tabname}_id` = '$element_id'";
                    /* Выполняем запрос. Если произойдет ошибка - вывести ее. */
                    $mysqli->query($query) or die($query);
                }
            }

        }

        for ($i = ($num_rows - $num_rows_more); $i++ < $num_rows;) {
            $j = $i - 1;

            $element_id = $element_id_arr[$j];
            $component_name = $_POST['component_name_'.$i];
            $component_gross = $_POST['gross_'.$i];
            $component_net = $_POST['net_'.$i];
            $component_comment = $_POST['component_comment_'.$i];


            if ($component_name == '0' || $component_gross == '0' || $component_net == '0' ||
                $component_name == '' || $component_gross == '' || $component_net == '')
            {
                if ($diagnostics_event == 'on') {
//     Диагностика данных, которые мы вносим!
//           Блок разделён на три части
//             Это блок №2 - "данные"
                    echo '<b>Обработка строки: ' . $i . '<br></b>';
                    echo '<span style="color: red;">Строка с нулём !!! Пропускаем !!!</span><br><br>';
                }
                $num_rows_corrector--;
            }
            else
            {

                if ($diagnostics_event == 'on') {
                    //     Диагностика данных, которые мы вносим!
                    //           Блок разделён на три части
                    //             Это блок №2 - "данные"
                    echo '<b>Обработка строки: ' . $i . '<br></b>';
                    echo 'Действие: <span style="color: red;">Добавляем строку</span> <b>||</b> ';
                    echo 'Имя компонента: <span style="color: red;">' . $component_name . '</span> <b>||</b> ';
                    echo 'Вес Брутто: <span style="color: red;">' . $component_gross . '</span> <b>||</b> ';
                    echo 'Вес Нетто: <span style="color: red;">' . $component_net . '</span> <b>||</b> ';
                    echo 'Комментарий: <span style="color: red;">' . $component_comment . '</span><br><br>';
                }


                $query = "INSERT INTO `{$tabname}s`
                (`{$tabname}_id`,`{$tabname}_name`,`component_name`,`component_gross`,`component_net`,`component_comment`)
                VALUES  (NULL,'$add_name','$component_name','$component_gross','$component_net','$component_comment')";
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

        $num_rows = $num_rows_corrector;
    }
// Добаление данных в Базу Данных
// Работает хорошо
    else if($_POST['actiontype'] == 'add') {

        $num_rows_corrector = $num_rows;

        if ($diagnostics_event == 'on') {
//     Диагностика данных, которые мы вносим!
//           Блок разделён на три части
//             Это блок №1 - "хидер"
            echo '<div class="diagnostika-2">';
//                 НЕ ИСПОЛЬЗУЕМ
//     потому что не влезает по высоте на экран

            echo "<h2>Hi NEW ITEM!</h2>";
            echo 'Вносим: <span style="color: red;">'.$add_name.'</span><br>';
            echo 'Количество строк: <span style="color: red;">'.$num_rows.'</span><br><br>';
        }


        for ($i = 0; $i++ < $num_rows;) {


            $component_name = $_POST['component_name_'.$i];
            $component_gross = $_POST['gross_'.$i];
            $component_net = $_POST['net_'.$i];
            $component_comment = $_POST['component_comment_'.$i];

            if ($component_name == '0' || $component_gross == '0' || $component_net == '0' ||
                $component_name == '' || $component_gross == '' || $component_net == '')
            {
                if ($diagnostics_event == 'on') {
//     Диагностика данных, которые мы вносим!
//           Блок разделён на три части
//             Это блок №2 - "данные"
                    echo '<b>Обработка строки: ' . $i . '<br></b>';
                    echo '<span style="color: red;">Строка с нулём !!! Пропускаем !!!</span><br><br>';
                }
                $num_rows_corrector--;
            }
            else
            {

                if ($diagnostics_event == 'on') {
                    //     Диагностика данных, которые мы вносим!
                    //           Блок разделён на три части
                    //             Это блок №2 - "данные"
                    echo '<b>Обработка строки: ' . $i . '<br></b>';
                    echo 'Имя компонента: <span style="color: red;">' . $component_name . '</span> <b>||</b> ';
                    echo 'Вес Брутто: <span style="color: red;">' . $component_gross . '</span> <b>||</b> ';
                    echo 'Вес Нетто: <span style="color: red;">' . $component_net . '</span> <b>||</b> ';
                    echo 'Комментарий: <span style="color: red;">' . $component_comment . '</span><br><br>';
                }


                $query = "INSERT INTO `{$tabname}s`
                (`{$tabname}_id`,`{$tabname}_name`,`component_name`,`component_gross`,`component_net`,`component_comment`)
                VALUES  (NULL,'$add_name','$component_name','$component_gross','$component_net','$component_comment')";
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

        $num_rows = $num_rows_corrector;
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

        <?php


        echo "<h1 class='display-1'>Рецепты</h1>";


        ?>
        <br>

        <!--      Блок с кнопками навигации по заполнению данных в меню       -->
        <!-- Должна отображаться структура наполнения от Полуфабриката к Сету -->

        <div>
            <a href="semi.php" class="btn btn-outline-info">Полуфабрикаты</a>
            <a href="#" class="btn btn-outline-primary">Комплекты</a>
            <a href="recipe.php" class="btn btn-success">Рецепты</a>
            <a href="#" class="btn btn-outline-warning">Блюда</a>
            <a href="#" class="btn btn-outline-danger">Сеты</a>
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
                    <h4>Редактирование полуфабриката \"$name\"</h4>
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
                $reason = trim($reason, '\u000A');
                echo "
                    <h4>Ошибка: <span style='color: red;'>$reason</span></h4>
                        <div class='mistakeform'>
                        <form action='".$urlform."' class='form-horizontal' method='post'>
                            <div class='container'>
                                <div class='form-group row'>
                                    <div class='col-xs-12'>
                                        <div class='form-group has-danger'>
                                            <input type='text' value='".$add_name."' class='col-xs-3 form-control form-control-danger' id='add_name_mistake' name='add_name_mistake' required>
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
                                            </div>
                                            ";
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


//            $options_products = '';
//            $query = "SELECT * FROM `products` ORDER BY product_name";
//            $selproduct = $mysqli->query($query) or die($query);
//            while (($optproduct = $selproduct->fetch_assoc()) != false)
//            {
//                $options_products = $options_products.'<option value="'.$optproduct['product_name'].'">'.$optproduct['product_name'].'</option>';
//            }

            echo '<div id="add_field_area">';
            //  Вывод строк для внесения в них данных!
            for ($i=0; $i++ < $num_rows;) echo rowform($i,$event,$edit_name,$tabname);
            echo '</div>';




            echo '<div class="form-group row">';
            // Кнопки [Внести изменения] и [Добавить]


            // Отображение для редактирования
            if ($showtype == 'show_edit')
            {
                echo "
                <div class='col-xs-6'>
                    <div onclick='addField();' class='btn btn-outline-info addbutton'>Добавить новое поле</div>
                </div>
                <div class='col-xs-6'>
                    <input type='hidden' id='new_num_rows' name='num_rows' value='".$num_rows."'>
                    <input type='hidden' name='edit_name' value='".$name."'>
                    <input type='hidden' name='showtype' value='show_manag'>
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
                    <input type='hidden' id='new_num_rows' name='num_rows' value='".$num_rows."'>
                    <input type='hidden' name='edit_name' value='".$name."'>
                    <input type='hidden' name='showtype' value='show_manag'>
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
                    <input type='hidden' id='new_num_rows' name='num_rows' value='".$num_rows."'>
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
                        <th class='td-right'>Вес</th>
                        <th class='td-right'>Стоимость</th>
                        <th class='td-right'>Белки</th>
                        <th class='td-right'>Жиры</th>
                        <th class='td-right'>Углеводы</th>
                        <th class='td-right'>Эн.ценность</th>
                        <th class='td-right'>Редакт.</th>
                    </tr>
                    </thead>
                    <tbody>                    
                ";


            $edbutt = 1;
            // Создаём массив для работы с ним
            $items_result_set = $mysqli->query("SELECT * FROM `{$tabname}s` ORDER BY {$tabname}_name");
            // Наполняем таблицу строками
            echo showTable ($items_result_set,$tabname,$nutr_val,$edbutt,$diagnostics_tab);


            echo "
                    </tbody>
                </table>
                
                <div class='pull-right' style='color: #aaa;'>Пищевая и энергетическая ценность в таблице указана на блюдо!</div>
                <br><br>
                
                
                </div>
                    
            ";
// Режим просмотра таблицы
        } else {

            if (isset($_POST['100']))
            {
                echo "
                <form action='".$urlform."' method='post' class='form-inline pull-right'>
                    <label for='100'>Сейчас пищевая ценность отображается 100 грамм!&nbsp;&nbsp;&nbsp;</label>
                    <button type='submit' id='100' name='100-dish' class='btn btn-outline-secondary'>Пересчитать на блюдо!</button>
                </form>
                ";
                $nutr_val = '1';
            }
            else
            {
                echo "
                <form action='".$urlform."' method='post' class='form-inline pull-right'>
                    <label for='100'>Сейчас пищевая ценность отображается на блюдо!&nbsp;&nbsp;&nbsp;</label>
                    <button type='submit' id='100' name='100' class='btn btn-outline-secondary'>Пересчитать на 100 грамм!</button>
                </form>
                ";
                $nutr_val = '0';
            }

            echo "
            <br><br>
            <table class='table table-hover'>
                <thead>
                <tr>
                    <th>№ п/п</th>
                    <th>Наименование</th>
                    <th class='td-right'>Вес</th>
                    <th class='td-right'>Стоимость</th>
                    <th class='td-right'>Белки</th>
                    <th class='td-right'>Жиры</th>
                    <th class='td-right'>Углеводы</th>
                    <th class='td-right'>Эн.ценность</th>
                </tr>
                </thead>

                <tbody>

                ";


            $edbutt = 0;
            // Создаём массив для работы с ним
            $items_result_set = $mysqli->query("SELECT * FROM `{$tabname}s` ORDER BY {$tabname}_name");
            // Наполняем таблицу строками
            echo showTable ($items_result_set,$tabname,$nutr_val,$edbutt,$diagnostics_tab);


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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>
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
<script>

    function addField () {
        var numrow = $('#new_num_rows').val();
        numrow++;
        var telnum = parseInt($('#add_field_area').find('div.add:last').attr('id').slice(3))+1;

        /*        alert("telnum_base = "+telnum_base+" telnum = "+telnum); */

        $('div#add_field_area').append('<div id="add'+telnum+'" class="add row"><!-- Компонент рецепта --><div class="col-xs-4"><div class="form-group"><select class="form-control" id="component_name_'+telnum+'" name="component_name_'+telnum+'" required><option value="">Выберите компонент №'+telnum+'</option><option value="0">- не использовать -</option><optgroup label="Сырьё и упаковка"><?php echo $options_products ?></optgroup></select></div></div><!-- Количество компонента БРУТТО --><div class="col-xs-2"><div class="form-group"><input type="number" min="0.001" max="5" step="0.001" placeholder="Брутто" class="col-xs-2 form-control" id="gross_'+telnum+'" name="gross_'+telnum+'" required></div></div><!-- Количество компонента НЕТТО --><div class="col-xs-2"><div class="form-group"><input type="number" min="0.001" max="5" step="0.001" placeholder="Нетто" class="col-xs-2 form-control" id="net_'+telnum+'" name="net_'+telnum+'" required></div></div><!-- Комментарий к компоненту --><div class="col-xs-3"><div class="form-group"><input type="text" placeholder="Комментарий" class="col-xs-4 form-control" id="component_comment_'+telnum+'" name="component_comment_'+telnum+'"></div></div><!-- Управляющие конструкции --><div class="col-xs-1"><div class="form-group deletebutton" onclick="deleteField('+telnum+');"><i class="fa fa-times fa" aria-hidden="true" style="color: red;"></i></div></div></div>');
        $('#new_num_rows').val(numrow);
    }

    function deleteField (id) {
        /* Закомментировал уменьшение $num_row потому что передаётся количество строк,
         а это может не соответствовать номеру строки. Так, например, мы создали 5 строк
         удалили строки 3 и 4. У нас осталось 3 строки с номерами 1, 2 и 5. При обработке,
         оставь мы уменьшение $num_row, мы бы обрабатывали строки 1, 2 и 3 а до 5-ой точно
         не добрались бы и данные из неё не попали в БД! */

        /* var numrow = $('#new_num_rows').val();
         numrow--; */
        /*        alert("id = "+id); */
        $('div#add'+id).remove();
        /* $('#new_num_rows').val(numrow); */
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