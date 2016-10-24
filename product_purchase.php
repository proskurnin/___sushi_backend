<!DOCTYPE html>
<html lang="ru">
<?php

// ВАЖНО!!!
// В этом файле переменная $add_name является составляющей из
// даты $date и номера чека $fiscal_receipt


// Адрес страницы во всех формах
$urlform = 'product_purchase.php';
// Название таблицы БД, с которой работаем, добавляется в конце s. Имеем имяs
// Поле имя в данной таблице обызательно имя_name
// Поле id, если нужно, имеет вид имя_id. Связи таблиц решил делать через name. Нужно чтобы было уникальным.
$tabname = 'products_purchase';

// Пароль на редактирование данной страницы
$password = '11';
// Включение ДИАГНОСТИКИ переменных (on/off)
$diagnostics_var = 'off';
// Включение ДИАГНОСТИКИ событий (on/off)
$diagnostics_event = 'off';

$options_products = '';


?>
<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Склад</title>

    <?php include 'modules/_header.txt'; ?>

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

    global $options_products;

    if ($event == 'event_first') {

        $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
        $mysqli->query("SET NAMES 'utf8'");


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
        
                    <!-- Позиция покупки -->
                        <div class='col-xs-4'>
                            <div class='form-group'>
                            <select class='form-control selectpicker' id='product_{$i}' name='product_{$i}' required>
                                    <option value=''>Выберите покупку №{$i}</option>
                                    <optgroup label='Сырьё и упаковка'>
                                        {$options_products}
                                    </optgroup>
                            </select>
                            </div>
                        </div>
            
            
                    <!-- Количество по приходу -->
                        <div class='col-xs-2'>
                            <div class='form-group'>
                                <div class='input-group'>
                                    <input type='number' min='0.001' max='1000.000' step='0.00001' size='8' pattern='\d+(,\d{3})?' placeholder='Количество' class='col-xs-2 form-control' id='amount_{$i}' name='amount_{$i}' required>
                                    <span class='input-group-addon'><i class='fa fa-shopping-bag' aria-hidden='true'></i></span>
                                </div>
                            </div>
                        </div>
            
            
                    <!-- Оплачено -->
                        <div class='col-xs-2'>
                            <div class='form-group'>
                                <div class='input-group'>
                                    <input type='number' min='0.01' max='5000.00' step='0.01' size='8' pattern='\d+(,\d{3})?' placeholder='Оплачено' class='col-xs-2 form-control' id='cost_{$i}' name='cost_{$i}' required>
                                    <span class='input-group-addon'><i class='fa fa-rub' aria-hidden='true'></i></span>
                                </div>
                            </div>
                        </div>
            
            
                    <!-- Комментарий к компоненту -->
                        <div class='col-xs-3'>
                            <div class='form-group'>
                                <input type='text' placeholder='Комментарий' class='col-xs-4 form-control' id='comment_{$i}' name='comment_{$i}'>
                            </div>
                        </div>
                    
                    
                    <!-- Управляющие конструкции -->
                        <div class='col-xs-1'>
                            <div class='form-group deletebutton' onclick='deleteField({$i});'><p class='form-control-static'>
                                <i class='fa fa-trash-o' aria-hidden='true' style='color: red; cursor: pointer'></i>
                            </p></div>
                        </div>
                    </div>
                    ";


    }


// Вывод полей при ошибке!
    if ($event == 'event_mistake') {

        $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
        $mysqli->query("SET NAMES 'utf8'");

        $select_option = $_POST['product_'.$i];

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
                    <select class='form-control form-control-danger selectpicker' id='component_name_{$i}' name='component_name_{$i}' required>
                        <option value=''>Не указано!</option>
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
                    <select class='form-control form-control-success selectpicker' id='component_name_{$i}' name='component_name_{$i}' required>
                        <option value='{$select_option}'>{$select_option}</option>
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
                        <p class='form-control-static'>
                            <i class='fa fa-trash-o' aria-hidden='true' style='color: red; cursor: pointer'></i>
                        </p>
                    </div>
                </div>
            </div>
            ";
    }



// Вывод полей при редактировании!
    if ($event == 'event_edit') {

        $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
        $mysqli->query("SET NAMES 'utf8'");


        $query = "SELECT  `product_name` FROM  `{$tabname}s` WHERE  `{$tabname}_name` =  '$edit_name'";
        $db_product = $mysqli->query($query) or die($query);
        while (($db_element_product = $db_product->fetch_assoc()) != false)
        {
            $element_product_db[] = array_shift($db_element_product);
        }

        $query = "SELECT  `product_amount` FROM  `{$tabname}s` WHERE  `{$tabname}_name` =  '$edit_name'";
        $db_amount = $mysqli->query($query) or die($query);
        while (($db_element_amount = $db_amount->fetch_assoc()) != false)
        {
            $element_amount_db[] = array_shift($db_element_amount);
        }

        $query = "SELECT  `product_cost` FROM  `{$tabname}s` WHERE  `{$tabname}_name` =  '$edit_name'";
        $db_cost = $mysqli->query($query) or die($query);
        while (($db_element_cost = $db_cost->fetch_assoc()) != false)
        {
            $element_cost_db[] = array_shift($db_element_cost);
        }

        $query = "SELECT  `product_comment` FROM  `{$tabname}s` WHERE  `{$tabname}_name` =  '$edit_name'";
        $db_comment = $mysqli->query($query) or die($query);
        while (($db_element_comment = $db_comment->fetch_assoc()) != false)
        {
            $element_comment_db[] = array_shift($db_element_comment);
        }

        $j = $i - 1;


// Строим выпадающий список продуктов. Выбор продуктов в списке по NAME
        $options_products = '';
        $query = "SELECT * FROM `products` ORDER BY product_name";
        $selproduct = $mysqli->query($query) or die($query);
        while (($optproduct = $selproduct->fetch_assoc()) != false)
        {
            $options_products = $options_products.'<option value="'.$optproduct['product_name'].'">'.$optproduct['product_name'].'</option>';
        }
        $mysqli->close();


// Формируем элемент ПОЗИЦИЯ ПОКУПКИ
        if ($element_product_db[$j] == '0' || $element_product_db[$j] == '') {
            $element_product = "
            <div class='col-xs-4'>
                <div class='form-group'>
                <select class='form-control selectpicker' id='product_{$i}' name='product_{$i}' required>
                    <option value=''>Выберите покупку {$i}</option>
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
            $element_product = "
            <div class='col-xs-4'>
                <div class='form-group has-warning'>
                <select class='form-control form-control-warning selectpicker' id='product_{$i}' name='product_{$i}' required>
                    <option value='".$element_product_db[$j]."'>".$element_product_db[$j]."</option>
                    <optgroup label='Сырьё и упаковка'>
                        {$options_products}
                    </optgroup>
                </select>
                </div>
            </div>
            ";
        }

// Формируем элемент КОЛИЧЕСТВО ПО ПРИХОДУ
        $element_amount = "
        <div class='col-xs-2'>
            <div class='form-group has-warning'>
                <div class='input-group'>
                    <input type='number' min='0.001' max='1000.000' step='0.00001' size='8' pattern='\d+(,\d{3})?' value='".$element_amount_db[$j]."' class='col-xs-3 form-control form-control-warning' id='amount_{$i}' name='amount_{$i}' required>
                    <span class='input-group-addon'><i class='fa fa-shopping-bag' aria-hidden='true'></i></span>
                </div>
            </div>
        </div>
        ";


// Формируем элемент ОПЛАЧЕНО
        $element_cost = "
        <div class='col-xs-2'>
            <div class='form-group has-warning'>
                <div class='input-group'>
                    <input type='number' min='0.01' max='5000.00' step='0.01' size='8' pattern='\d+(,\d{3})?' value='".$element_cost_db[$j]."' class='col-xs-3 form-control form-control-warning' id='cost_{$i}' name='cost_{$i}' required>
                    <span class='input-group-addon'><i class='fa fa-rub' aria-hidden='true'></i></span>
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
                        <input type='text' placeholder='Комментарий' class='col-xs-3 form-control' id='comment_{$i}' name='comment_{$i}'>
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
                        <input type='text' value='".$element_comment_db[$j]."' class='col-xs-3 form-control form-control-warning' id='comment_{$i}' name='comment_{$i}'>            
                    </div>
                </div>
            </div>
            ";
        }




        $rowOfComponent = "
        
        <div id='add$i' class='add row'>
        
        <!-- Компонент рецепта -->
            {$element_product}

        <!-- Количество компонента БРУТТО -->
            {$element_amount}


        <!-- Количество компонента НЕТТО -->
            {$element_cost}


        <!-- Комментарий к компоненту -->
            {$element_comment}
        
        <!-- Управляющие конструкции -->
            <div class='col-xs-1'>
                <div class='form-group deletebutton' onclick='deleteField({$i});'>
                    <p class='form-control-static'>
                        <i class='fa fa-trash-o' aria-hidden='true' style='color: red; cursor: pointer'></i>
                    </p>
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
function showTable ($result_set,$tabname,$edbutt,$diagnostics_tab)
{

    $mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
    $mysqli->query("SET NAMES 'utf8'");

// ПЕРЕМЕННЫЕ
    global $urlform;

    $npp = 0;
    $item_name = '';
    $item_name_check = '';
    $collaps_block = '';
    $date = '';
    $fiscal_receipt = '';
    $vendor = '';
    $cost = '';

    while (($row = $result_set->fetch_assoc()) != false) {

        if ($diagnostics_tab == 'on') {
//     Диагностика данных!
            if ($item_name_check !== $row[$tabname . '_name']) {
                echo "<br>";
                echo "<h2>" . $row[$tabname . '_name'] . "</h2>";
            }
        }

        if ($item_name_check !== $row[$tabname.'_name'])
        {
            if ($npp !== 0)
            {
                echo "
                <tr>
                    <td>" . $npp . "</td>
                    <td>" . $date . "</td>
                    <td>" . $fiscal_receipt . "</td>
                    <td>";

                    $query = "SELECT * FROM `vendors` ORDER BY  vendor_name";
                    $vendor_set = $mysqli->query($query) or die($query);
                    while (($urow = $vendor_set->fetch_assoc()) != false) {
                        if ($vendor == $urow['vendor_id']) {
                            echo $urow['vendor_name'];
                        }
                    }

                echo "
                    </td>
                    <td class='td-right'>" . number_format($cost, 2, ',', ' ') . "</td>";

                if ($edbutt == '1') {
                    echo "
                    <td class='td-right'>
                        <!-- Button trigger modal -->
                        <a data-toggle='collapse' href='#collapse_".$npp."' aria-expanded='false' aria-controls='collapse_".$npp."'>
                            <i class='fa fa-info-circle' aria-hidden='true'></i></a>

                        &nbsp;&nbsp;

                        <a name='del' href=".$urlform."?del=".urlencode($item_name)." onclick ='return confirm(\"Удалить {$item_name}?\")'>
                            <i class='fa fa-trash-o' aria-hidden='true' style='color: red;'></i></a>

                        &nbsp;&nbsp;

                        <a name='edit' href=".$urlform."?editrow=editrow&edit_name=".urlencode($item_name).">
                            <i class='fa fa-pencil-square-o' aria-hidden='true' style='color: cornflowerblue;'></i></a>
                    </td>
                    ";
                }
                echo "
                </tr>";

                $collaps_block = $collaps_block."
                                                </tbody>
                                                </table>
                                                </div>
                                                </td>
                                                </tr>
                                                ";

                echo $collaps_block;
            }

            $npp++;
            $collaps_block = "<tr class='infoblock'><td colspan='9'>
            <div class='collapse' id='collapse_".$npp."'>
                <table class='table table-sm'>
                    <thead>
                        <tr>
                            <th>Продукт</th>
                            <th class='td-right'>Количество</th>
                            <th class='td-right'>Стоимость</th>
                            <th class='nakopit'>( <i class='fa fa-plus' aria-hidden='true'></i> )</th>
                            <th class='td-right'>Цена</th>
                        </tr>
                    </thead>
                    <tbody>
                ";


// Место в коде для "сброса" и "переназначения" ПЕРЕМЕННЫХ !!!
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

            $cost = 0;
            $date = $row[$tabname.'_date'];
            $fiscal_receipt = $row['fiscal_receipt'];
            $vendor = $row['vendor_id'];

// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
        }

        $item_name = $row[$tabname.'_name'];
        $item_name_check = $row[$tabname.'_name'];

// Формирование разворачивающегося блока
        foreach ($row as $k => $v) {
            if (($k == $tabname.'_name') && ($v == $item_name))
            {
                $cost = $cost + $row["product_cost"];
                if ($row['product_name'] == 'misc') $cl = "class='semi'"; else $cl = "";
                $collaps_block = $collaps_block."
                <tr ".$cl.">
                    <td>".$row['product_name']."</td>
                    <td class='td-right'>".number_format($row["product_amount"], 3, ',', ' ')."</td>
                    <td class='td-right'>".number_format($row["product_cost"], 2, ',', ' ')."</td>
                    <td class='nakopit'>(".number_format($cost, 2, ',', ' ').")</td>
                    <td class='td-right'>".number_format($row["product_price"], 2, ',', ' ')."</td>
                </tr>
                ";
            }
        }
    }

// Вывод самой последней строки в таблице!
    if ($npp !== 0)
    {
        echo "
                <tr>
                    <td>" . $npp . "</td>
                    <td>" . $date . "</td>
                    <td>" . $fiscal_receipt . "</td>
                    <td>";

                    $query = "SELECT * FROM `vendors` ORDER BY  vendor_name";
                    $vendor_set = $mysqli->query($query) or die($query);
                    while (($urow = $vendor_set->fetch_assoc()) != false) {
                        if ($vendor == $urow['vendor_id']) {
                            echo $urow['vendor_name'];
                        }
                    }

                echo "
                    </td>
                    <td class='td-right'>" . number_format($cost, 2, ',', ' ') . "</td>";

        if ($edbutt == '1') {
            echo "
                    <td class='td-right'>
                        <!-- Button trigger modal -->
                        <a data-toggle='collapse' href='#collapse_".$npp."' aria-expanded='false' aria-controls='collapse_".$npp."'>
                            <i class='fa fa-info-circle' aria-hidden='true'></i></a>

                        &nbsp;&nbsp;

                        <a name='del' href=".$urlform."?del=".urlencode($item_name)." onclick ='return confirm(\"Удалить {$item_name}?\")'>
                            <i class='fa fa-trash-o' aria-hidden='true' style='color: red;'></i></a>

                        &nbsp;&nbsp;

                        <a name='edit' href=".$urlform."?editrow=editrow&edit_name=".urlencode($item_name).">
                            <i class='fa fa-pencil-square-o' aria-hidden='true' style='color: cornflowerblue;'></i></a>
                    </td>
                    ";
        }
        echo "
                </tr>";

        $collaps_block = $collaps_block."
                </tbody>
            </table>
        </div>
    </td>
</tr>
";

// Вывод блока, который разворачивается, когда нажимаешь на ссылку "i"
        echo $collaps_block;
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
    $query = "SELECT  `product_name` FROM  `{$tabname}s` WHERE  `{$tabname}_name` =  '$row_name'";
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

// и $name для отображения в поле Название продукта
if (isset($_GET['edit_name'])) {$name = $edit_name = $_GET['edit_name'];}
else if (isset($_POST['edit_name'])) {$name = $edit_name = $_POST['edit_name'];}
else {$name = $edit_name = -1;}

// Дата чека
$date = $_POST['ppurch_date'];

// Номер чека
if (isset($_POST['fiscal_receipt'])) {$fiscal_receipt = $_POST['fiscal_receipt'];}
else if (isset($_POST['fiscal_receipt_edit'])) {$fiscal_receipt = $_POST['fiscal_receipt_edit'];}
else if (isset($_POST['fiscal_receipt_mistake'])) {$fiscal_receipt = $_POST['fiscal_receipt_mistake'];}
else {$fiscal_receipt = -1;}

// Поставщик
$vendor = $_POST['vendor'];

// Сумма прочего
$misc_cost = $_POST['misc_cost'];

// Комментарий к прочему
$misc_comment = $_POST['misc_comment'];

// и $add_name для внесения в поле номер чека
$add_name = $date.'_'.$fiscal_receipt;


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
$query = "SELECT `{$tabname}_name` FROM `{$tabname}s` ORDER BY {$tabname}_name";
$db_names = $mysqli->query($query) or die($query);

//    echo "<h3>Проверка на уникальность названия $add_name </h3><br>";
while (($db_item_names = $db_names->fetch_assoc()) != false) {

    if ((($add_name == $db_item_names[$tabname.'_name']) ||
            ($add_name == $db_item_names[$tabname.'_name']) ||
            ($add_name == $db_item_names[$tabname.'_name']))
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
        $reason = $reason . 'Такой чек уже внесён!\u000A';
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
                          `recipe_type` = '$recipe_type',
                          `recipe_group` = '$recipe_group',
                          `recipe_view` = '$recipe_view',
                          `component_name` = '$component_name',
                          `component_gross` = '$component_gross',
                          `component_net` = '$component_net',
                          `component_comment` = '$component_comment',
                          `last_update` = CURRENT_TIMESTAMP
                          WHERE  
                          `{$tabname}_id` = '$element_id'";
                    /* Выполняем запрос. Если произойдет ошибка - вывести ее. */
                    $mysqli->query($query) or die($query);
                }
            }
        }

        for ($i = ($num_rows - $num_rows_more); $i++ < $num_rows;) {
            $j = $i - 1;

            $product = $_POST['product_'.$i];
            $amount = $_POST['amount_'.$i];
            $cost = $_POST['cost_'.$i];
            $price = $cost / $amount;
            $comment = $_POST['comment_'.$i];


            if ($product == '0' || $amount == '0' || $cost == '0' ||
                $product == '' || $amount == '' || $cost == '')
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



// Добавление данных в базу данных!
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
            else
            {

                if ($diagnostics_event == 'on') {
                    //     Диагностика данных, которые мы вносим!
                    //           Блок разделён на три части
                    //             Это блок №2 - "данные"
                    echo '<b>Обработка строки: ' . $i . '<br></b>';
                    echo 'Действие: <span style="color: red;">Добавляем строку</span> <b>||</b> ';
                    echo 'Покупка: <span style="color: red;">' . $product . '</span> <b>||</b> ';
                    echo 'Количество: <span style="color: red;">' . $amount . '</span> <b>||</b> ';
                    echo 'Стоимость: <span style="color: red;">' . $cost . '</span> <b>||</b> ';
                    echo 'Цена: <span style="color: red;">' . $price . '</span> <b>||</b> ';
                    echo 'Комментарий: <span style="color: red;">' . $comment . '</span><br><br>';
                }



                $query = "INSERT INTO `{$tabname}s`
                (`{$tabname}_id`,`{$tabname}_name`,`{$tabname}_date`,`fiscal_receipt`,`vendor_id`,`product_name`,`product_amount`,`product_cost`,`product_price`,`product_comment`)
                VALUES  (NULL,'$add_name','$date','$fiscal_receipt','$vendor','$product','$amount','$cost','$price','$comment')";
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
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
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
            echo 'Вносим чек номер: <span style="color: red;">'.$fiscal_receipt.'</span><br>';
            echo 'Дата чека: <span style="color: red;">'.$date.'</span><br>';
            echo '(<span style="color: red;">'.$add_name.'</span>)<br>';
            echo 'Количество строк: <span style="color: red;">'.$num_rows.'</span><br>';
            if ($misc_cost > 0 || $misc_comment != '') {
                echo 'Прочих покупок на сумму: <span style="color: red;">'.$misc_cost.'</span><br><br>';
            } else {
                echo 'Раздел "прочее" не заполнен<br><br>';
            }
        }


        for ($i = 0; $i++ < $num_rows;) {


            $product = $_POST['product_'.$i];
            $amount = $_POST['amount_'.$i];
            $cost = $_POST['cost_'.$i];
            $price = $cost / $amount;
            $comment = $_POST['comment_'.$i];

            if ($product == '0' || $amount == '0' || $cost == '0' ||
                $product == '' || $amount == '' || $cost == '')
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
                    echo 'Покупка: <span style="color: red;">' . $product . '</span> <b>||</b> ';
                    echo 'Количество: <span style="color: red;">' . $amount . '</span> <b>||</b> ';
                    echo 'Стоимость: <span style="color: red;">' . $cost . '</span> <b>||</b> ';
                    echo 'Цена: <span style="color: red;">' . $price . '</span> <b>||</b> ';
                    echo 'Комментарий: <span style="color: red;">' . $comment . '</span><br><br>';
                }


                $query = "INSERT INTO `{$tabname}s`
                (`{$tabname}_id`,
                 `{$tabname}_name`,
                 `{$tabname}_date`,
                 `fiscal_receipt`,
                 `vendor_id`,
                 `product_name`,
                 `product_amount`,
                 `product_cost`,
                 `product_price`,
                 `product_comment`)
                VALUES 
                (NULL,
                 '$add_name',
                 '$date',
                 '$fiscal_receipt',
                 '$vendor',
                 '$product',
                 '$amount',
                 '$cost',
                 '$price',
                 '$comment')";
                /* Выполняем запрос. Если произойдет ошибка - вывести ее. */
                $mysqli->query($query) or die($query);

                $query = "SELECT  `store_online` FROM  `products` WHERE  `product_name` =  '$product' LIMIT 1";
                $db_store_online_prod = $mysqli->query($query) or die($query);
                while (($db_store_online = $db_store_online_prod->fetch_assoc()) != false)
                {
                    $store_online = array_shift($db_store_online);
                }
                $store_online = $store_online + $amount;

                $query = "UPDATE `products`
                          SET                              
                          `store_online` = '$store_online',
                          `last_update` = CURRENT_TIMESTAMP
                          WHERE
                          `product_name` =  '$product'";
                /* Выполняем запрос. Если произойдет ошибка - вывести ее. */
                $mysqli->query($query) or die($query);
            }
        }


// Если заполнили раздел "ПРОЧЕЕ" до добавляем "продукт" misc (прочее) в БД для учёта денег,
// которые потратили на это самое прочее
        if ($misc_cost > 0 || $misc_comment != '') {
            $query = "INSERT INTO `{$tabname}s`
                (`{$tabname}_id`,
                 `{$tabname}_name`,
                 `{$tabname}_date`,
                 `fiscal_receipt`,
                 `vendor_id`,
                 `product_name`,
                 `product_amount`,
                 `product_cost`,
                 `product_price`,
                 `product_comment`)
                VALUES 
                (NULL,
                 '$add_name',
                 '$date',
                 '$fiscal_receipt',
                 '$vendor',
                 'misc',
                 '0',
                 '$misc_cost',
                 '0',
                 '$misc_comment')";
            /* Выполняем запрос. Если произойдет ошибка - вывести ее. */
            $mysqli->query($query) or die($query);
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
<?php include 'modules/_navigation.txt'; ?>
<!-- /Контейнер с навигацией -->

<div class="container">
    <div class="row">
        <br>
        <h1 class="display-1">Покупка сырья</h1>
        <br>
        <div>
            <a href="product.php" class="btn btn-outline-info">Склад</a>
            <a href="product_purchase.php" class="btn btn-success">Купить</a>
            <a href="product_salvage.php" class="btn btn-outline-danger">Списать</a>
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
            echo '$date = <span style="color: red;">' . $date . '</span><br>';
            echo '$fiscal_receipt = <span style="color: red;">' . $fiscal_receipt . '</span><br>';
            echo '$vendor = <span style="color: red;">' . $vendor . '</span><br>';
            echo '$misc_cost = <span style="color: red;">' . $misc_cost . '</span><br>';
            echo '$misc_comment = <span style="color: red;">' . $misc_comment . '</span><br>';
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



// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
// ФОРМА работы с данными
// Заголовок поля формы добавления и редактирования данных

            if ($showtype == 'show_edit')
            {
                echo "
                    <h4>Редактирование чека \"$fiscal_receipt\"</h4>
                        <div class='editform'>
                        <form action='".$urlform."' class='form-horizontal' method='post'>
                            <div class='container'>
                                <div class='row'>
                                
                                    <div class='col-xs-12'>
                                        <div class='form-group has-warning'>
                                            <input type='text'  class='col-xs-3 form-control form-control-warning' id='fiscal_receipt_edit' name='fiscal_receipt_edit' required>
                                        </div>
                                    </div>
                                    
                                    <div class='col-xs-4'>    
                                        <div class='form-group'>
                                            <div class='input-group'>
                                                <input type='date' value='".$date."' class='col-xs-3 form-control' id='ppurch_date' name='ppurch_date' required>
                                                <span class='input-group-addon'><i class='fa fa-calendar' aria-hidden='true'></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-xs-4'>    
                                        <div class='form-group'>
                                            <div class='input-group'>
                                                <input type='text' value='".$fiscal_receipt."' class='col-xs-3 form-control' id='fiscal_receipt' name='fiscal_receipt' required>
                                                <span class='input-group-addon'><i class='fa fa-list-alt' aria-hidden='true'></i></span>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class='col-xs-4'>
                                        <div class='form-group'>
                                            <div class='input-group'>";

                                        // Строим выпадающий список мест покупки (поставщиков).
                                        $vendors_list = '';
                                        $query = "SELECT * FROM `vendors` ORDER BY vendor_name ASC";
                                        $sel_vendors = $mysqli->query($query) or die($query);
                                        while (($opt_vendors = $sel_vendors->fetch_assoc()) != false)
                                        {
                                            $vendors_list = $vendors_list.'<option value="'.$opt_vendors['vendor_id'].'">'.$opt_vendors['vendor_name'].'</option>';
                                        }


                    echo "
                                            <select class='form-control selectpicker' id='vendor' name='vendor' required>
                                                <option value='{$vendor}'>{$vendor}</option>
                                                <optgroup label='Поставщики:'>
                                                    {$vendors_list}
                                                </optgroup>
                                            </select>
                                            </div>
                                        </div>  
                                    
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
                                    <div class='col-xs-12'>
                                        <div class='form-group has-danger'>
                                            <input type='text' value='".$fiscal_receipt."' class='col-xs-3 form-control form-control-danger' id='fiscal_receipt_mistake' name='fiscal_receipt_mistake' required>
                                        </div>
                                    </div>  
                                </div>
                                ";
            }
            else if ($showtype == 'show_manag' || isset($_GET['del']))
            {
                echo "
                    <h4>Добавление нового чека</h4>
                        <div class='addform'>
                        <form action='".$urlform."' class='form-horizontal' method='post'>
                            <div class='container'>
                                <div class='row'>
                                    ";

                if ($event == 'event_first')
                {
                    echo "
                                    <div class='col-xs-4'>    
                                        <div class='form-group'>
                                            <div class='input-group'>
                                                <input type='date' placeholder='Дата покупки' class='col-xs-3 form-control' id='$date' name='ppurch_date' required>
                                                <span class='input-group-addon'><i class='fa fa-calendar' aria-hidden='true'></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-xs-4'>    
                                        <div class='form-group'>
                                            <div class='input-group'>
                                                <input type='text' placeholder='Номер чека' class='col-xs-3 form-control' id='fiscal_receipt' name='fiscal_receipt' required>
                                                <span class='input-group-addon'><i class='fa fa-list-alt' aria-hidden='true'></i></span>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class='col-xs-4'>
                                        <div class='form-group'>
                                            <div class='input-group'>";

                                        // Строим выпадающий список мест покупки (поставщиков).
                                        $vendors_list = '';
                                        $query = "SELECT * FROM `vendors` ORDER BY vendor_name ASC";
                                        $sel_vendors = $mysqli->query($query) or die($query);
                                        while (($opt_vendors = $sel_vendors->fetch_assoc()) != false)
                                        {
                                            $vendors_list = $vendors_list.'<option value="'.$opt_vendors['vendor_id'].'">'.$opt_vendors['vendor_name'].'</option>';
                                        }


                    echo "
                                            <select class='form-control selectpicker' id='vendor' name='vendor' required>
                                                <option value=''>Укажите поставщика</option>
                                                <optgroup label='Поставщики:'>
                                                    {$vendors_list}
                                                </optgroup>
                                            </select>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                                
                                ";
                }
                // Отображение данных, когда все указано ВЕРНО
                else
                {
                    echo "
                                        
                                    <div class='col-xs-4'>    
                                        <div class='form-group has-success'>
                                            <div class='input-group'>
                                                <input type='date' placeholder='Дата покупки' class='col-xs-3 form-control form-control-success' id='ppurch_date' name='ppurch_date' required>
                                                <span class='input-group-addon'><i class='fa fa-calendar' aria-hidden='true'></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-xs-4'>    
                                        <div class='form-group has-success'>
                                            <div class='input-group'>
                                                <input type='text' value='".$fiscal_receipt."' class='col-xs-3 form-control form-control-success' id='fiscal_receipt' name='fiscal_receipt' required>
                                                <span class='input-group-addon'><i class='fa fa-list-alt' aria-hidden='true'></i></span>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class='col-xs-4'>
                                        <div class='form-group has-success'>
                                            <div class='input-group'>";

                                        // Строим выпадающий список мест покупки (поставщиков).
                                        $vendors_list = '';
                                        $query = "SELECT * FROM `vendors` ORDER BY vendor_name ASC";
                                        $sel_vendors = $mysqli->query($query) or die($query);
                                        while (($opt_vendors = $sel_vendors->fetch_assoc()) != false)
                                        {
                                            $vendors_list = $vendors_list.'<option value="'.$opt_vendors['vendor_id'].'">'.$opt_vendors['vendor_name'].'</option>';
                                        }


                    echo "
                                            <select class='form-control form-control-success selectpicker' id='vendor' name='vendor' required>
                                                <option value=''>Укажите поставщика</option>
                                                <optgroup label='Поставщики:'>
                                                    {$vendors_list}
                                                </optgroup>
                                            </select>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                                
                                ";
                }
            }


            echo '<div id="add_field_area">';
//  Вывод строк для внесения в них данных!
            for ($i=0; $i++ < $num_rows;) echo rowform($i,$event,$edit_name,$tabname);
            echo '</div>';


// Нижняя строка "ПРОЧЕЕ" и Кнопки [Внести изменения] и [Добавить]
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

// Отображение для редактирования
            if ($showtype == 'show_edit')
            {
                $name = $date.'_'.$fiscal_receipt;
                echo "

            <div class='form-group row'>
                <div class='col-xs-1 '>
                    <p class='form-control-static'>Прочее:</p>
                </div>
            <!-- Оплачено -->
                <div class='col-xs-3'>
                    <div class='form-group'>
                        <div class='input-group'>
                            <input type='number' min='0.01' max='5000.00' step='0.01' size='8' pattern='\d+(,\d{3})?' placeholder='Оплачено' class='col-xs-2 form-control' id='misc_cost' name='misc_cost'>
                            <span class='input-group-addon'><i class='fa fa-rub' aria-hidden='true'></i></span>
                        </div>
                    </div>
                </div>
            <!-- Комментарий к компоненту -->
                <div class='col-xs-8'>
                    <div class='form-group'>
                        <input type='text' placeholder='Комментарий' class='col-xs-4 form-control' id='misc_comment' name='misc_comment'>
                    </div>
                </div>
            </div>
            
            <!-- КНОПКИ -->
            <div class='form-group row'>
                <div class='col-xs-6'>
                    <div onclick='addField();' class='btn btn-secondary addbutton'>Добавить новое поле</div>
                </div>
                <div class='col-xs-6'>
                    <input type='hidden' id='new_num_rows' name='num_rows' value='".$num_rows."'>
                    <input type='hidden' name='edit_name' value='".$name."'>
                    <input type='hidden' name='showtype' value='show_manag'>
                    <input type='hidden' name='actiontype' value='edit'>
                    <button type='submit' name='edititem' class='btn btn-outline-warning pull-right'>Внести изменение</button>
                </div>
            </div>";
            }
            else if ($showtype == 'show_mistake')
            {
                $name = $date.'_'.$fiscal_receipt;
                echo "
                
            <div class='form-group row'>
                <div class='col-xs-1 '>
                    <p class='form-control-static'>Прочее:</p>
                </div>
            <!-- Оплачено -->
                <div class='col-xs-3'>
                    <div class='form-group'>
                        <div class='input-group'>
                            <input type='number' min='0.01' max='5000.00' step='0.01' size='8' pattern='\d+(,\d{3})?' placeholder='Оплачено' class='col-xs-2 form-control' id='misc_cost' name='misc_cost'>
                            <span class='input-group-addon'><i class='fa fa-rub' aria-hidden='true'></i></span>
                        </div>
                    </div>
                </div>
            <!-- Комментарий к компоненту -->
                <div class='col-xs-8'>
                    <div class='form-group'>
                        <input type='text' placeholder='Комментарий' class='col-xs-4 form-control' id='misc_comment' name='misc_comment'>
                    </div>
                </div>
            </div>
           
            <!-- КНОПКИ -->
            <div class='form-group row'>
                <div class='col-xs-6'>
                    <div onclick='addField();' class='btn btn-secondary addbutton'>Добавить новое поле</div>
                </div>
                <div class='col-xs-6'>
                    <input type='hidden' id='new_num_rows' name='num_rows' value='".$num_rows."'>
                    <input type='hidden' name='edit_name' value='".$name."'>
                    <input type='hidden' name='showtype' value='show_manag'>
                    <input type='hidden' name='actiontype' value='edit'>
                    <button type='submit' name='edititem' class='btn btn-outline-danger pull-right'>Исправить данные</button>
                </div>
            </div>";
            }
            else if ($showtype == 'show_manag' || isset($_GET['del']))
            {
                echo "
                
            <div class='row'>
                <div class='col-xs-1 '>
                    <p class='form-control-static'>Прочее:</p>
                </div>
            <!-- Оплачено -->
                <div class='col-xs-3'>
                    <div class='form-group'>
                        <div class='input-group'>
                            <input type='number' min='0.01' max='5000.00' step='0.01' size='8' pattern='\d+(,\d{3})?' placeholder='Оплачено' class='col-xs-2 form-control' id='misc_cost' name='misc_cost'>
                            <span class='input-group-addon'><i class='fa fa-rub' aria-hidden='true'></i></span>
                        </div>
                    </div>
                </div>
            <!-- Комментарий к компоненту -->
                <div class='col-xs-8'>
                    <div class='form-group'>
                        <input type='text' placeholder='Комментарий' class='col-xs-4 form-control' id='misc_comment' name='misc_comment'>
                    </div>
                </div>
            </div>
            
            <!-- КНОПКИ -->
            <div class='form-group row'>
                <div class='col-xs-6'>
                    <div onclick='addField();' class='btn btn-secondary addbutton'>Добавить новое поле</div>
                </div>
                <div class='col-xs-6'>
                    <input type='hidden' id='new_num_rows' name='num_rows' value='".$num_rows."'>
                    <input type='hidden' name='showtype' value='show_manag'>
                    <input type='hidden' name='actiontype' value='add'>
                    <button type='submit' name='addnewitem' class='btn btn-outline-primary pull-right'>Добавить чек</button>
                </div>
            </div>";
            }


            echo "
                            </div>
                        </div>
                    </form>
                    </div>
                        
                ";


// Конец ФОРМЫ
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =





            echo "
                <br>
                <table class='table table-hover' id='check_tab'>
                    <thead>
                    <tr>
                        <th>№ п/п</th>
                        <th>Дата</th>
                        <th>№ чека</th>
                        <th>Поставщик</th>
                        <th class='td-right'>Сумма чека</th>
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
            echo showTable ($items_result_set,$tabname,$edbutt,$diagnostics_tab);


            echo "
                    </tbody>
                </table>
                
                <br>";






// Режим просмотра таблицы
        } else {



            echo "
            <br>
            отображать за:
            <a name='showtime' href=" . $urlform . "?showtime=curmonth> 
                текущий месяц
            </a>
             : 
            <a name='showtime' href=" . $urlform . "?showtime=lastmonth> 
                предыдущий месяц
            </a>
             : 
            <a name='showtime' href=" . $urlform . "?showtime=alltime> 
                всё время
            </a>
            <br><br>
            <table class='table table-hover'>
                <thead>
                    <tr>
                        <th>№ п/п</th>
                        <th>Дата</th>
                        <th>№ чека</th>
                        <th>Поставщик</th>
                        <th class='td-right'>Сумма чека</th>
                    </tr>
                </thead>

                <tbody>

                ";

            $edbutt = 0;
            // Создаём массив для работы с ним
            if($_GET['showtime'] == 'curmonth' || $_GET['showtime'] == '' || $_GET['showtime'] == 0)
            {
                $query = "
                    SELECT *
                    FROM `{$tabname}s`
                    WHERE `products_purchase_date` > LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH
                    AND `products_purchase_date` < DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY)
                    ORDER BY `{$tabname}_name` DESC";
            }
            if($_GET['showtime'] == 'lastmonth')
            {
                $query = "
                    SELECT *
                    FROM `{$tabname}s`
                    WHERE `products_purchase_date` > LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 2 MONTH))
                    AND `products_purchase_date` < DATE_ADD(LAST_DAY(CURDATE() - INTERVAL 1 MONTH), INTERVAL 1 DAY)
                    ORDER BY `{$tabname}_name` DESC";
            }
            if($_GET['showtime'] == 'alltime')
            {
                $query = "SELECT * FROM `{$tabname}s` ORDER BY `{$tabname}_name` DESC";
            }
            
            
            
            
            
            $items_result_set = $mysqli->query($query) or die($query);
            // Наполняем таблицу строками
            echo showTable ($items_result_set,$tabname,$edbutt,$diagnostics_tab);


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

<?php include 'modules/_footer.txt'; ?>


<script>

    function addField () {
        var numrow = $('#new_num_rows').val();
        numrow++;
        var telnum = parseInt($('#add_field_area').find('div.add:last').attr('id').slice(3))+1;

        /*        alert("telnum_base = "+telnum_base+" telnum = "+telnum); */

        $('div#add_field_area').append('<div id="add'+telnum+'" class="add row">' +
            '' +
            '<!-- Позоция покупки --><div class="col-xs-4"><div class="form-group"><select class="form-control selectpicker" id="product_'+telnum+'" name="product_'+telnum+'" required><option value="">Выберите покупку №'+telnum+'</option><optgroup label="Сырьё и упаковка"><?php echo $options_products; ?></optgroup></select></div></div><!-- Количество по приходу --><div class="col-xs-2"><div class="form-group"><div class="input-group"><input type="number" min="0.001" max="1000.000" step="0.00001" size="8" pattern="\d+(,\d{3})?" placeholder="Количество" class="col-xs-2 form-control" id="amount_'+telnum+'" name="amount_'+telnum+'" required><span class="input-group-addon"><i class="fa fa-shopping-bag" aria-hidden="true"></i></span></div></div></div><!-- Оплачено --><div class="col-xs-2"><div class="form-group"><div class="input-group"><input type="number" min="0.01" max="5000.00" step="0.01" size="8" pattern="\d+(,\d{3})?" placeholder="Оплачено" class="col-xs-2 form-control" id="cost_'+telnum+'" name="cost_'+telnum+'" required><span class="input-group-addon"><i class="fa fa-rub" aria-hidden="true"></i></span></div></div></div><!-- Комментарий к компоненту --><div class="col-xs-3"><div class="form-group"><input type="text" placeholder="Комментарий" class="col-xs-4 form-control" id="comment_'+telnum+'" name="comment_'+telnum+'"></div></div>' +
            '' +
            '<!-- Управляющие конструкции --><div class="col-xs-1"><div class="form-group deletebutton" onclick="deleteField('+telnum+');"><p class="form-control-static"><i class="fa fa-trash-o" aria-hidden="true" style="color: red;"></i></p></div></div></div>');
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

</body>
</html>