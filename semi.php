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
$diagnostics_var = 'off';
// Включение ДИАГНОСТИКИ событий (on/off)
$diagnostics_event = 'off';
// Включение ДИАГНОСТИКИ переключения пищевой ценности (on/off)
$diagnostics_tab = 'off';

$options_semis = '';
$options_products = '';

?>
<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Полуфабрикаты</title>

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

    global $options_semis, $options_products;

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
                    $options_semis = $options_semis.'<option value="'.$optsemis['semi_name'].'">'.$optsemis['semi_name'].'</option>';
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
                    $options_semis = $options_semis.'<option value="'.$optsemis['semi_name'].'">'.$optsemis['semi_name'].'</option>';
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
                    $options_semis = $options_semis.'<option value="'.$optsemis['semi_name'].'">'.$optsemis['semi_name'].'</option>';
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
    include 'modules/showTable.php';
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




<?php



// Подключаемся к БД
$mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
// Выбираем кодовую страницу БД
$mysqli->query("SET NAMES 'utf8'");




// Удаление данных из таблицы
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
<?php include 'modules/_navigation.txt'; ?>
<!-- /Контейнер с навигацией -->

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
            <a href="dish.php" class="btn btn-outline-warning">Ассортимент</a>
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
                $options_products = $options_products.'<option value="'.$optproduct['product_name'].'">'.$optproduct['product_name'].'</option>';
            }

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
                    <label for='100'>Сейчас пищевая ценность отображается блюдо!&nbsp;&nbsp;&nbsp;</label>
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

<?php include 'modules/_footer.txt'; ?>


<script>

    function addField () {
        var numrow = $('#new_num_rows').val();
        numrow++;
        var telnum = parseInt($('#add_field_area').find('div.add:last').attr('id').slice(3))+1;

        /*        alert("telnum_base = "+telnum_base+" telnum = "+telnum); */

        $('div#add_field_area').append('<div id="add'+telnum+'" class="add row"><!-- Компонент рецепта --><div class="col-xs-4"><div class="form-group"><select class="form-control" id="component_name_'+telnum+'" name="component_name_'+telnum+'" required><option value="">Выберите компонент №'+telnum+'</option><option value="0">- не использовать -</option><optgroup label="Полуфабрикаты"><?php echo $options_semis; ?></optgroup><optgroup label="Сырьё и упаковка"><?php echo $options_products; ?></optgroup></select></div></div><!-- Количество компонента БРУТТО --><div class="col-xs-2"><div class="form-group"><input type="number" min="0.001" max="5" step="0.001" placeholder="Брутто" class="col-xs-2 form-control" id="gross_'+telnum+'" name="gross_'+telnum+'" required></div></div><!-- Количество компонента НЕТТО --><div class="col-xs-2"><div class="form-group"><input type="number" min="0.001" max="5" step="0.001" placeholder="Нетто" class="col-xs-2 form-control" id="net_'+telnum+'" name="net_'+telnum+'" required></div></div><!-- Комментарий к компоненту --><div class="col-xs-3"><div class="form-group"><input type="text" placeholder="Комментарий" class="col-xs-4 form-control" id="component_comment_'+telnum+'" name="component_comment_'+telnum+'"></div></div><!-- Управляющие конструкции --><div class="col-xs-1"><div class="form-group deletebutton" onclick="deleteField('+telnum+');"><i class="fa fa-times fa" aria-hidden="true" style="color: red;"></i></div></div></div>');
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