<?php

$mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
$mysqli->query("SET NAMES 'utf8'");

$npp = 0;
$item_name = '';
$item_name_check = '';
$collaps_block = '';

while (($row = $result_set->fetch_assoc()) != false) {

    $product_query = "SELECT * FROM `products` WHERE  `product_name` = '".$row['component_name']."'";
    $dbproduct = $mysqli->query($product_query) or die($product_query);
    /* определение числа рядов в выборке */
    $row_product_cnt = mysqli_num_rows($dbproduct);
    $product = $dbproduct->fetch_assoc();

    if ($diagnostics_tab == 'on') {
    //     Диагностика данных о подсчёте пищевой ценности!
    if ($item_name_check !== $row[$tabname . '_name']) {
    echo "<br>";
    echo "<h2>" . $row[$tabname . '_name'] . "</h2>";
    }
    }

    if ($item_name_check !== $row[$tabname.'_name'])
    {
        // Вывод строки таблицы (кроме последнего)
        if ($npp !== 0)
        {
            // Переключение режимов отображения пищевой ценности
            // на 100 грамм или на всё блюдо
            if ($nutr_val == '1') {$nutr = $item_amount / 0.1;} else {$nutr = 1;}

            $item_protein = $item_protein / $nutr;
            $item_fat = $item_fat / $nutr;
            $item_carbohydrate = $item_carbohydrate / $nutr;
            $item_energy = $item_energy / $nutr;

            // Сам вывод строки таблицы тут!
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

            $item_amount = 0;
            $item_cost = 0;
            $item_protein = 0;
            $item_fat = 0;
            $item_carbohydrate = 0;
            $item_energy = 0;
        }

        $npp++;

        // Шапка разворачивающегося блока
        $collaps_block = "
        <tr class='infoblock'><td colspan='9'>
            <div class='collapse' id='collapse_".$npp."'>
                <table class='table table-sm'>
                    <thead>
                    <tr>
                        <th>Компонент</th>
                        <th class='td-right'>Цена</th>
                        <th class='td-right'>Брутто</th>
                        <th class='td-right'>Нетто</th>
                        <th class='nakopit'>( <i class='fa fa-plus' aria-hidden='true'></i> )</th>
                        <th class='td-right'>Стоим.</th>
                        <th class='nakopit'>( <i class='fa fa-plus' aria-hidden='true'></i> )</th>
                        <th class='td-right'>Белки.</th>
                        <th class='nakopit'>( <i class='fa fa-plus' aria-hidden='true'></i> )</th>
                        <th class='td-right'>Жиры</th>
                        <th class='nakopit'>( <i class='fa fa-plus' aria-hidden='true'></i> )</th>
                        <th class='td-right'>Углев.</th>
                        <th class='nakopit'>( <i class='fa fa-plus' aria-hidden='true'></i> )</th>
                        <th class='td-right'>Эн.ценн.</th>
                        <th class='nakopit'>( <i class='fa fa-plus' aria-hidden='true'></i> )</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
    ";

    }

    $item_name = $row[$tabname.'_name'];
    $item_name_check = $row[$tabname.'_name'];



    if($row_product_cnt > 0)
    {
        $item_query = "SELECT * FROM `{$tabname}s` WHERE  `{$tabname}_name` = '" . $row['component_name'] . "'";


        foreach ($row as $k => $v) {

            if (($k == $tabname.'_name') && ($v == $item_name)) {
                $dbitems = $mysqli->query($item_query) or die($item_query);
                $item = $dbitems->fetch_assoc();

                if ($diagnostics_tab == 'on') {
                    //     Диагностика данных о подсчёте пищевой ценности!
                    echo "<br>";
                    echo "<b style='color: green;'>" . $row['component_name'] . "</b>";
                    echo "<b style='color: green;'> - НУЖНО ЧЕРЕЗ if СДЕЛАТЬ! </b><br>";
                    echo '<b style="color: red;">имя: </b>' . $row["component_name"] . ' : ';
                    echo '<b style="color: red;">брутто: </b>' . $row["component_gross"] . ' : ';
                    echo '<b style="color: red;">нетто: </b>' . $row["component_net"] . '<br>';
                }

                // КОЛИЧЕСТВО ЭЛЕМЕНТА
                // Если единици измерения штуки (unit_id = 3) или порции (unit_id = 4) не учитываем вес этого элемента
                if ($item["unit_id"] == '3' || $item["unit_id"] == '4') {
                } else {
                    $item_amount = $item_amount + $row["component_net"];
                }

                // ОПРЕДЕЛЕНИЕ "ЦЕНЫ ОНЛАЙН"
                // Очень важный модуль для верноего рассчёта себестоимостей!
                // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

                // Цена прошлого периода
                $price_old = 0;
                $price_summ = 0;
                $query_price = "
              SELECT `product_price`
              FROM `products_purchases`
              WHERE `products_purchase_date` > LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 2 MONTH))
                AND `products_purchase_date` < DATE_ADD(LAST_DAY(CURDATE() - INTERVAL 1 MONTH), INTERVAL 1 DAY)
                AND `product_name` = '" . $row['component_name'] . "'";
                $prices = $mysqli->query($query_price) or die($query_price);
                $prices_cnt = mysqli_num_rows($prices);
                if ($prices_cnt !== 0) {
                    while (($row_price = $prices->fetch_assoc()) != false) {
                        $price_summ = $price_summ + $row_price['product_price'];
                    }
                    $price_old = $price_summ / $prices_cnt;
                }


                // Определение средней цены за текущий месяц.
                $price_average = 0;
                $price_summ = 0;
                $query_price = "
              SELECT `product_price`
              FROM `products_purchases`
              WHERE `products_purchase_date` > LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH
                AND `products_purchase_date` < DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY)
                AND `product_name` = '" . $row['component_name'] . "'";
                $prices = $mysqli->query($query_price) or die($query_price);
                $prices_cnt = mysqli_num_rows($prices);
                if ($prices_cnt !== 0) {
                    while (($row_price = $prices->fetch_assoc()) != false) {
                        $price_summ = $price_summ + $row_price['product_price'];
                    }
                    $price_average = $price_summ / $prices_cnt;
                }

                // Если получается выислить среднюю цену за текущий месяц,
                // она становится ценой онлайн. В противном случае ценой онлайн
                // становится цена прошлого месяца. Если и её нет, то ценой онлайн становится цена,
                // которую ввёл пользователь.
                if ($price_average > 0) $price_online = $price_average;
                elseif ($price_old > 0) $price_online = $price_old;
                else $price_online = $product['price_start'];

                // КОНЕЦ БЛОКА - ОПРЕДЕЛЕНИЕ "ЦЕНЫ ОНЛАЙН"
                // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

                // ПРОЧИЕ ХАРАКТЕРИСТИКИ ЭЛЕМЕНТА
                $item_cost = $item_cost + $row["component_gross"] * $price_online;
                $item_protein = $item_protein + $row["component_net"] * $product["protein"] / 0.1;
                $item_fat = $item_fat + $row["component_net"] * $product["fat"] / 0.1;
                $item_carbohydrate = $item_carbohydrate + $row["component_net"] * $product["carbohydrate"] / 0.1;
                $item_energy = $item_energy + $row["component_net"] * $product["energy"] / 0.1;

                if ($diagnostics_tab == 'on') {
                    //     Диагностика данных о подсчёте пищевой ценности!
                    echo '$item_query = ' . $item_query . '<br>';
                    echo '$product_query = ' . $product_query . '<br>';
                    echo '$product[\'price_start\'] = ' . $product["price_start"] . '<br>';
                    echo '$price_average = ' . $price_average . '<br>';
                    echo '$price_old = ' . $price_old . '<br>';
                    echo '$price_online = ' . $price_online . '<br>';
                    echo '$row_product_cnt = ' . $row_product_cnt . '<br>';


                    echo $item_cost . '($item_cost) = ' . $item_cost . '($item_cost) + ' . $row["component_gross"] . '($row["component_gross"]) * ' . $price_online . '($price_online)<br>';
                    echo '<b style="color: #00c1cd;">цена: </b>' . number_format(($row["component_gross"] * $price_online), 2, ',', ' ') . ' (' . number_format($item_cost, 2, ',', ' ') . ') : ';
                    echo '<b style="color: #00c1cd;">кол: </b>' . number_format(($row["component_net"]), 3, ',', ' ') . ' (' . number_format($item_amount, 3, ',', ' ') . ') : ';
                    echo '<b style="color: #00c1cd;">белок: </b>' . number_format((($row["component_net"] * $product["protein"]) / 0.1), 3, ',', ' ') . ' (' . number_format($item_protein, 3, ',', ' ') . ') : ';
                    echo '<b style="color: #00c1cd;">жир: </b>' . number_format((($row["component_net"] * $product["fat"]) / 0.1), 3, ',', ' ') . ' (' . number_format($item_fat, 3, ',', ' ') . ') : ';
                    echo '<b style="color: #00c1cd;">углев: </b>' . number_format((($row["component_net"] * $product["carbohydrate"]) / 0.1), 3, ',', ' ') . ' (' . number_format($item_carbohydrate, 3, ',', ' ') . ') : ';
                    echo '<b style="color: #00c1cd;">энерг: </b>' . number_format((($row["component_net"] * $product["energy"]) / 0.1), 3, ',', ' ') . ' (' . number_format($item_energy, 3, ',', ' ') . ') <br>';
                }

                // ВЫПАДАЮЩИ БЛОК
                $collaps_block = $collaps_block . "
                <tr>
                    <td>" . $row['component_name'] . "</td>
                    <td class='td-right'>" . number_format($price_online, 2, ',', ' ') . "</td>
                    <td class='td-right'>" . number_format($row["component_gross"], 3, ',', ' ') . "</td>
                    <td class='td-right'>" . number_format($row["component_net"], 3, ',', ' ') . "</td>
                    <td class='nakopit'>(" . number_format($item_amount, 3, ',', ' ') . ")</td>

                    <td class='td-right'>" . number_format(($row["component_gross"] * $price_online), 2, ',', ' ') . "</td>
                    <td class='nakopit'>(" . number_format($item_cost, 2, ',', ' ') . ")</td>

                    <td class='td-right'>" . number_format((($row["component_net"] * $product["protein"]) / 0.1), 3, ',', ' ') . "</td>
                    <td class='nakopit'>(" . number_format($item_protein, 3, ',', ' ') . ")</td>

                    <td class='td-right'>" . number_format((($row["component_net"] * $product["fat"]) / 0.1), 3, ',', ' ') . "</td>
                    <td class='nakopit'>(" . number_format($item_fat, 3, ',', ' ') . ")</td>

                    <td class='td-right'>" . number_format((($row["component_net"] * $product["carbohydrate"]) / 0.1), 3, ',', ' ') . "</td>
                    <td class='nakopit'>(" . number_format($item_carbohydrate, 3, ',', ' ') . ")</td>

                    <td class='td-right'>" . number_format((($row["component_net"] * $product["energy"]) / 0.1), 3, ',', ' ') . "</td>
                    <td class='nakopit'>(" . number_format($item_energy, 3, ',', ' ') . ")</td>
                    
                    <td></td>
                </tr>
                ";


            }

        }


    }
    else
    {
        $item_query = "SELECT * FROM `semis` WHERE  `semi_name` = '".$row['component_name']."'";

        foreach ($row as $k => $v) {

            if (($k == $tabname.'_name') && ($v == $item_name))
            {
                $dbitems = $mysqli->query($item_query) or die($item_query);
                $item = $dbitems->fetch_assoc();

                    if ($diagnostics_tab == 'on')
                    {
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


                    while (($item_row = $dbitems->fetch_assoc()) != false) {

                        $semi_item_name = $item_row['semi_name'];

                        $query = "SELECT * FROM `products` WHERE  `product_name` = '".$semi_row['component_name']."'";

                        foreach ($item_row as $k => $v) {

                            if (($k == 'semi_name') && ($v == $semi_item_name))
                            {

                                if ($diagnostics_tab == 'on')
                                {
                                    //     Диагностика данных о подсчёте пищевой ценности!
                                    echo '<b style="color: blue;">имя: </b>' . $semi_row["component_name"] . ' : ';
                                    echo '<b style="color: blue;">брутто: </b>' . $semi_row["component_gross"] . ' : ';
                                    echo '<b style="color: blue;">нетто: </b>' . $semi_row["component_net"] . '<br>';
                                }

                                $dbproduct = $mysqli->query($query) or die($query);
                                $product = $dbproduct->fetch_assoc();

                                // ОПРЕДЕЛЕНИЕ "ЦЕНЫ ОНЛАЙН"
                                // Очень важный модуль для верноего рассчёта себестоимостей!
                                // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

                                // Цена прошлого периода
                                $price_old = 0;
                                $price_summ = 0;
                                $query_price = "
                                          SELECT `product_price`
                                          FROM `products_purchases`
                                          WHERE `products_purchase_date` > LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 2 MONTH))
                                            AND `products_purchase_date` < DATE_ADD(LAST_DAY(CURDATE() - INTERVAL 1 MONTH), INTERVAL 1 DAY)
                                            AND `product_name` = '".$item_name."'";
                                $prices = $mysqli->query($query_price) or die($query_price);
                                $prices_cnt = mysqli_num_rows($prices);
                                if ($prices_cnt !== 0)
                                {
                                    while (($row_price = $prices->fetch_assoc()) != false) {
                                        $price_summ = $price_summ + $row_price['product_price'];
                                    }
                                    $price_old = $price_summ / $prices_cnt;
                                }

                                // Определение средней цены за текущий месяц.
                                $price_average = 0;
                                $price_summ = 0;
                                $query_price = "
                                          SELECT `product_price`
                                          FROM `products_purchases`
                                          WHERE `products_purchase_date` > LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH
                                            AND `products_purchase_date` < DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY)
                                            AND `product_name` = '".$item_name."'";
                                $prices = $mysqli->query($query_price) or die($query_price);
                                $prices_cnt = mysqli_num_rows($prices);
                                if ($prices_cnt !== 0)
                                {
                                    while (($row_price = $prices->fetch_assoc()) != false) {
                                        $price_summ = $price_summ + $row_price['product_price'];
                                    }
                                    $price_average = $price_summ / $prices_cnt;
                                }

                                // Если получается выислить среднюю цену за текущий месяц,
                                // она становится ценой онлайн. В противном случае ценой онлайн
                                // становится цена прошлого месяца. Если и её нет, то ценой онлайн становится цена,
                                // которую ввёл пользователь.
                                if ($price_average > 0) $price_online = $price_average;
                                elseif ($price_old >0) $price_online = $price_old;
                                else $price_online = $product['price_start'];


                                // КОНЕЦ БЛОКА - ОПРЕДЕЛЕНИЕ "ЦЕНЫ ОНЛАЙН"
                                // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =


                                // Если единици измерения штуки (unit_id = 3) или порции (unit_id = 4) не учитываем вес этого элемента
                                if ($product["unit_id"] == '3' || $product["unit_id"] == '4') { } else {
                                    $s_item_amount = $s_item_amount + $semi_row["component_net"];
                                }

                                $s_item_cost = $s_item_cost + $semi_row["component_gross"] * $price_online;
                                $s_item_protein = $s_item_protein + $semi_row["component_net"] * $product["protein"];
                                $s_item_fat = $s_item_fat + $semi_row["component_net"] * $product["fat"];
                                $s_item_carbohydrate = $s_item_carbohydrate + $semi_row["component_net"] * $product["carbohydrate"];
                                $s_item_energy = $s_item_energy + $semi_row["component_net"] * $product["energy"];


                                // НЕ СДЕЛАН БЛОК !!!
                                // Должен быть блок разворачивания состава полуфабриката (i)
                                // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
                                $collaps_sub_block = $collaps_sub_block."
                                        <tr>
                                            <td>".$semi_row['component_name']."</td>
                                            <td class='td-right'>".number_format($price_online, 2, ',', ' ')."</td>
                                            <td class='td-right'>".number_format($semi_row["component_gross"], 3, ',', ' ')."</td>
                                            <td class='td-right'>".number_format($semi_row["component_net"], 3, ',', ' ')."</td>
                                            <td class='nakopit'>(".number_format($nakopit_item_amount, 3, ',', ' ').")</td>
                        
                                            <td class='td-right'>".number_format(($semi_row["component_gross"] * $price_online), 2, ',', ' ') ."</td>
                                            <td class='nakopit'>(".number_format($nakopit_item_cost, 2, ',', ' ').")</td>
                        
                                            <td class='td-right'>".number_format((($semi_row["component_net"] * $product["protein"]) / 0.1), 3, ',', ' ') . "</td>
                                            <td class='nakopit'>(".number_format($nakopit_item_protein, 3, ',', ' ').")</td>
                        
                                            <td class='td-right'>".number_format((($semi_row["component_net"] * $product["fat"]) / 0.1), 3, ',', ' ') ."</td>
                                            <td class='nakopit'>(".number_format($nakopit_item_fat, 3, ',', ' ').")</td>
                        
                                            <td class='td-right'>".number_format((($semi_row["component_net"] * $product["carbohydrate"]) / 0.1), 3, ',', ' ') ."</td>
                                            <td class='nakopit'>(".number_format($nakopit_item_carbohydrate, 3, ',', ' ').")</td>
                        
                                            <td class='td-right'>".number_format((($semi_row["component_net"] * $product["energy"]) / 0.1), 3, ',', ' ') ."</td>
                                            <td class='nakopit'>(".number_format($nakopit_item_energy, 3, ',', ' ').")</td>
                                            
                                            <td></td>
                                        </tr>
                                        ";
                                // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

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


                    // Если единици измерения штуки (unit_id = 3) или порции (unit_id = 4) не учитываем вес этого элемента
                    if ($product["unit_id"] == '3' || $product["unit_id"] == '4') {

                    } else {
                        $nakopit_item_amount = $nakopit_item_amount + $row["component_net"];
                    }
                    $nakopit_item_cost = $nakopit_item_cost + $semi_item_cost;
                    $nakopit_item_protein = $nakopit_item_protein + $semi_item_protein;
                    $nakopit_item_fat = $nakopit_item_fat + $semi_item_fat;
                    $nakopit_item_carbohydrate = $nakopit_item_carbohydrate + $semi_item_carbohydrate;
                    $nakopit_item_energy = $nakopit_item_energy + $semi_item_energy;


                    if ($edbutt == '1') {
                        $collaps_block = $collaps_block . "
                                    <tr class='semi'>
                                        <td>" . $row['component_name'] . "</td>
                                        <td class='td-right'>" . number_format(($s_item_cost / $s_item_amount), 2, ',', ' ') . "</td>
                                        <td class='td-right'>" . number_format($row["component_gross"], 3, ',', ' ') . "</td>
                                        <td class='td-right'>" . number_format($row["component_net"], 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_amount, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($semi_item_cost, 2, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_cost, 2, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($semi_item_protein, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_protein, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($semi_item_fat, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_fat, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($semi_item_carbohydrate, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_carbohydrate, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($semi_item_energy, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_energy, 3, ',', ' ') . ")</td>
                                        <td>
                                            <a data-toggle='collapse' href='#collapse_sub_" . $npp . "' aria-expanded='false' aria-controls='collapse_sub_" . $npp . "'>
                                                <i class='fa fa-info-circle' aria-hidden='true'></i>
                                            </a>
                                        </td>
                                    </tr>
                                    ";
                    } else {
                        $collaps_block = $collaps_block . "
                                    <tr class='semi'>
                                        <td>" . $row['component_name'] . "</td>
                                        <td class='td-right'>" . number_format(($s_item_cost / $s_item_amount), 2, ',', ' ') . "</td>
                                        <td class='td-right'>" . number_format($row["component_gross"], 3, ',', ' ') . "</td>
                                        <td class='td-right'>" . number_format($row["component_net"], 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_amount, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($semi_item_cost, 2, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_cost, 2, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($semi_item_protein, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_protein, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($semi_item_fat, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_fat, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($semi_item_carbohydrate, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_carbohydrate, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($semi_item_energy, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_energy, 3, ',', ' ') . ")</td>
                                        <td></td>
                                    </tr>
                                    ";
                    }

            }
        }
    }
}




// Вывод последний строки таблицы!
if ($npp !== 0)
{
    // Переключение режимов отображения пищевой ценности
    // на 100 грамм или на всё блюдо

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

    $item_amount = 0;
    $item_cost = 0;
    $item_protein = 0;
    $item_fat = 0;
    $item_carbohydrate = 0;
    $item_energy = 0;
}
$mysqli->close();

?>