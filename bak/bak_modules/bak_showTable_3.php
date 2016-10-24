<?php

$mysqli = new mysqli("localhost", "u0216880_sushi", "02oL1NdiCm", "u0216880_sushi");
$mysqli->query("SET NAMES 'utf8'");

$npp = 0;
$item_name = '';
$item_name_check = '';
$collaps_block = '';

while (($row = $result_set->fetch_assoc()) != false) {

    if ($diagnostics_tab == 'on') {
    //     Диагностика данных о подсчёте пищевой ценности!
    if ($item_name_check !== $row[$tabname . '_name']) {
    echo "<br>";
    echo "<h2>" . $row[$tabname . '_name'] . "</h2>";
    }
    }

    //        if ($item_name_check !== $row[$tabname . '_name']) {
    //            $collaps_block = '';
    //        }

    if ($item_name_check !== $row[$tabname.'_name'])
    {
    if ($npp !== 0)
    {

        $item_amount = $nakopit_item_amount;
        $item_cost = $nakopit_item_cost;
        $item_protein = $nakopit_item_protein;
        $item_fat = $nakopit_item_fat;
        $item_carbohydrate = $nakopit_item_carbohydrate;
        $item_energy = $nakopit_item_energy;

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

        echo $collaps_block;
    }

    echo "
    
    
    ";

    $npp++;

    $collaps_block = "<tr class='infoblock'><td colspan='9'>
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



                    $item_amount = 0;
                    $item_cost = 0;
                    $item_protein = 0;
                    $item_fat = 0;
                    $item_carbohydrate = 0;
                    $item_energy = 0;

                    $nakopit_item_amount = 0;
                    $nakopit_item_cost = 0;
                    $nakopit_item_protein = 0;
                    $nakopit_item_fat = 0;
                    $nakopit_item_carbohydrate = 0;
                    $nakopit_item_energy = 0;

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
                    $query_pres = "SELECT * FROM `presets` WHERE  `preset_name` = '".$row['component_name']."'";
                    $query_reci = "SELECT * FROM `recipes` WHERE  `recipe_name` = '".$row['component_name']."'";

                    foreach ($row as $k => $v) {

                        if (($k == $tabname.'_name') && ($v == $item_name))
                        {
                            $dbproduct = $mysqli->query($query_prod) or die($query_prod);
                            /* определение числа рядов в выборке продуктов */
                            $row_prod_cnt = mysqli_num_rows($dbproduct);

                            $dbsemi = $mysqli->query($query_semi) or die($query_semi);
                            /* определение числа рядов в выборке полуфабрикатов */
                            $row_semi_cnt = mysqli_num_rows($dbsemi);

                            $dbpres = $mysqli->query($query_pres) or die($query_pres);
                            /* определение числа рядов в выборке комплектов */
                            $row_pres_cnt = mysqli_num_rows($dbpres);

                            $dbreci = $mysqli->query($query_reci) or die($query_reci);
                            /* определение числа рядов в выборке рецептов */
                            $row_reci_cnt = mysqli_num_rows($dbreci);


                            if ($row_prod_cnt > 0)
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

                                // Если единици измерения штуки (unit_id = 3) или порции (unit_id = 4) не учитываем вес этого элемента
                                if ($product["unit_id"] == '3' || $product["unit_id"] == '4') {

                                } else {
                                    $prod_item_amount = $prod_item_amount + $row["component_net"];
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


                                $prod_item_cost = $prod_item_cost + $row["component_gross"] * $price_online;
                                $prod_item_protein = $prod_item_protein + $row["component_net"] * $product["protein"] / 0.1;
                                $prod_item_fat = $prod_item_fat + $row["component_net"] * $product["fat"] / 0.1;
                                $prod_item_carbohydrate = $prod_item_carbohydrate + $row["component_net"] * $product["carbohydrate"] / 0.1;
                                $prod_item_energy = $prod_item_energy + $row["component_net"] * $product["energy"] / 0.1;

                                if ($diagnostics_tab == 'on') {
                                    //     Диагностика данных о подсчёте пищевой ценности!
                                    echo '<b style="color: #00c1cd;">цена: </b>' . number_format(($row["component_gross"] * $price_online), 2, ',', ' ') . ' ('.number_format($prod_item_cost, 2, ',', ' ').') : ';
                                    echo '<b style="color: #00c1cd;">кол: </b>' . number_format(($row["component_net"]), 3, ',', ' ') . ' ('.number_format($prod_item_amount, 3, ',', ' ').') : ';
                                    echo '<b style="color: #00c1cd;">белок: </b>' . number_format((($row["component_net"] * $product["protein"]) / 0.1), 3, ',', ' ') . ' ('.number_format($prod_item_protein, 3, ',', ' ').') : ';
                                    echo '<b style="color: #00c1cd;">жир: </b>' . number_format((($row["component_net"] * $product["fat"]) / 0.1), 3, ',', ' ') . ' ('.number_format($prod_item_fat, 3, ',', ' ').') : ';
                                    echo '<b style="color: #00c1cd;">углев: </b>' . number_format((($row["component_net"] * $product["carbohydrate"]) / 0.1), 3, ',', ' ') . ' ('.number_format($prod_item_carbohydrate, 3, ',', ' ').') : ';
                                    echo '<b style="color: #00c1cd;">энерг: </b>' . number_format((($row["component_net"] * $product["energy"]) / 0.1), 3, ',', ' ') . ' ('.number_format($prod_item_energy, 3, ',', ' ').') <br>';
                                }

                                // Если единици измерения штуки (unit_id = 3) или порции (unit_id = 4) не учитываем вес этого элемента
                                if ($product["unit_id"] == '3' || $product["unit_id"] == '4') {

                                } else {
                                    $nakopit_item_amount = $nakopit_item_amount + $row["component_net"];
                                }
                                $nakopit_item_cost = $nakopit_item_cost + $row["component_gross"] * $price_online;
                                $nakopit_item_protein = $nakopit_item_protein + $row["component_net"] * $product["protein"] / 0.1;
                                $nakopit_item_fat = $nakopit_item_fat + $row["component_net"] * $product["fat"] / 0.1;
                                $nakopit_item_carbohydrate = $nakopit_item_carbohydrate + $row["component_net"] * $product["carbohydrate"] / 0.1;
                                $nakopit_item_energy = $nakopit_item_energy + $row["component_net"] * $product["energy"] / 0.1;


                                $collaps_block = $collaps_block."
                                <tr>
                                    <td>".$row['component_name']."</td>
                                    <td class='td-right'>".number_format($price_online, 2, ',', ' ')."</td>
                                    <td class='td-right'>".number_format($row["component_gross"], 3, ',', ' ')."</td>
                                    <td class='td-right'>".number_format($row["component_net"], 3, ',', ' ')."</td>
                                    <td class='nakopit'>(".number_format($nakopit_item_amount, 3, ',', ' ').")</td>
                
                                    <td class='td-right'>".number_format(($row["component_gross"] * $price_online), 2, ',', ' ') ."</td>
                                    <td class='nakopit'>(".number_format($nakopit_item_cost, 2, ',', ' ').")</td>
                
                                    <td class='td-right'>".number_format((($row["component_net"] * $product["protein"]) / 0.1), 3, ',', ' ') . "</td>
                                    <td class='nakopit'>(".number_format($nakopit_item_protein, 3, ',', ' ').")</td>
                
                                    <td class='td-right'>".number_format((($row["component_net"] * $product["fat"]) / 0.1), 3, ',', ' ') ."</td>
                                    <td class='nakopit'>(".number_format($nakopit_item_fat, 3, ',', ' ').")</td>
                
                                    <td class='td-right'>".number_format((($row["component_net"] * $product["carbohydrate"]) / 0.1), 3, ',', ' ') ."</td>
                                    <td class='nakopit'>(".number_format($nakopit_item_carbohydrate, 3, ',', ' ').")</td>
                
                                    <td class='td-right'>".number_format((($row["component_net"] * $product["energy"]) / 0.1), 3, ',', ' ') ."</td>
                                    <td class='nakopit'>(".number_format($nakopit_item_energy, 3, ',', ' ').")</td>
                                    
                                    <td></td>
                                </tr>
                                ";
                            }

                            if ($row_semi_cnt > 0)
                            {
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


                                while (($semi_row = $dbsemi->fetch_assoc()) != false) {

                                    $semi_item_name = $semi_row['semi_name'];
                                    //                            $item_name_check = $semi_row['semi_name'];

                                    $query = "SELECT * FROM `products` WHERE  `product_name` = '".$semi_row['component_name']."'";

                                    foreach ($semi_row as $k => $v) {

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

                            if ($row_pres_cnt > 0)
                            {
                                if ($diagnostics_tab == 'on')
                                {
                                    //     Диагностика данных о подсчёте пищевой ценности!
                                    echo "<br>";
                                    echo "<b style='color: green;'>" . $row['component_name'] . "</b>";
                                    echo "<b style='color: green;'> - это комплект! </b><br>";
                                    echo '<b style="color: red;">имя: </b>' . $row["component_name"] . ' : ';
                                    echo '<b style="color: red;">количество: </b>' . $row["component_amount"] . ' : ';
                                    echo '<b style="color: blue;">Единица комплекта состоит из: </b><br>';
                                }

                                $p_item_amount = 0;
                                $p_item_cost = 0;
                                $p_item_protein = 0;
                                $p_item_fat = 0;
                                $p_item_carbohydrate = 0;
                                $p_item_energy = 0;


                                while (($pres_row = $dbpres->fetch_assoc()) != false) {

                                    $pres_item_name = $pres_row['preset_name'];
                                    //                            $item_name_check = $semi_row['semi_name'];

                                    $query = "SELECT * FROM `presets` WHERE  `preset_name` = '".$pres_row['component_name']."'";

                                    foreach ($pres_row as $k => $v) {

                                        if (($k == 'preset_name') && ($v == $pres_item_name))
                                        {

                                            if ($diagnostics_tab == 'on')
                                            {
                                                //     Диагностика данных о подсчёте пищевой ценности!
                                                echo '<b style="color: blue;">имя: </b>' . $pres_row["component_name"] . ' : ';
                                                echo '<b style="color: blue;">брутто: </b>' . $pres_row["component_gross"] . ' : ';
                                                echo '<b style="color: blue;">нетто: </b>' . $pres_row["component_net"] . '<br>';

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
                                                $p_item_amount = $p_item_amount + $pres_row["component_net"];
                                            }

                                            $p_item_cost = $p_item_cost + $pres_row["component_gross"] * $price_online;
                                            $p_item_protein = $p_item_protein + $pres_row["component_net"] * $product["protein"];
                                            $p_item_fat = $p_item_fat + $pres_row["component_net"] * $product["fat"];
                                            $p_item_carbohydrate = $p_item_carbohydrate + $pres_row["component_net"] * $product["carbohydrate"];
                                            $p_item_energy = $p_item_energy + $pres_row["component_net"] * $product["energy"];


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

                                    echo '<b style="color: #0000cd;">цена: </b>' . number_format($p_item_cost, 2, ',', ' ') . ' : ';
                                    echo '<b style="color: #0000cd;">кол: </b>' . number_format($p_item_amount, 3, ',', ' ') . ' : ';
                                    echo '<b style="color: #0000cd;">белок: </b>' . number_format($p_item_protein, 3, ',', ' ') . ' : ';
                                    echo '<b style="color: #0000cd;">жир: </b>' . number_format($p_item_fat, 3, ',', ' ') . ' : ';
                                    echo '<b style="color: #0000cd;">углев: </b>' . number_format($p_item_carbohydrate, 3, ',', ' ') . ' : ';
                                    echo '<b style="color: #0000cd;">энерг: </b>' . number_format($p_item_energy, 3, ',', ' ') . '<br>';
                                }

                                $pres_item_cost = $p_item_cost / $p_item_amount * $row["component_gross"];
                                $pres_item_protein = $p_item_protein / $p_item_amount * $row["component_net"];
                                $pres_item_fat = $p_item_fat / $p_item_amount * $row["component_net"];
                                $pres_item_carbohydrate = $p_item_carbohydrate / $p_item_amount * $row["component_net"];
                                if ($diagnostics_tab == 'on') {
                                    //     Диагностика данных о подсчёте пищевой ценности!
                                    echo '<b style="color: #cd1824;">проверка эн.ценности: </b><br>'
                                        . number_format($pres_item_energy, 3, ',', ' ') .
                                        ' = '
                                        . number_format($p_item_energy, 3, ',', ' ') .
                                        ' / '
                                        . number_format($p_item_amount, 3, ',', ' ') .
                                        ' * '
                                        . number_format($row["component_net"], 3, ',', ' ') .
                                        '<br>';
                                }
                                $pres_item_energy = $p_item_energy / $p_item_amount * $row["component_net"];
                                $pres_item_amount = $p_item_amount / $p_item_amount * $row["component_net"];

                                if ($diagnostics_tab == 'on') {
                                    //     Диагностика данных о подсчёте пищевой ценности!
                                    echo '<b style="color: #00c1cd;">Показатель эн.ценности на ' . number_format($pres_item_amount, 3, ',', ' ') . ' кг.: </b><br>';

                                    echo '<b style="color: #00c1cd;">цена: </b>' . number_format($pres_item_cost, 2, ',', ' ') . ' : ';
                                    echo '<b style="color: #00c1cd;">кол: </b>' . number_format($pres_item_amount, 3, ',', ' ') . ' : ';
                                    echo '<b style="color: #00c1cd;">белок: </b>' . number_format($pres_item_protein, 3, ',', ' ') . ' : ';
                                    echo '<b style="color: #00c1cd;">жир: </b>' . number_format($pres_item_fat, 3, ',', ' ') . ' : ';
                                    echo '<b style="color: #00c1cd;">углев: </b>' . number_format($pres_item_carbohydrate, 3, ',', ' ') . ' : ';
                                    echo '<b style="color: #00c1cd;">энерг: </b>' . number_format($pres_item_energy, 3, ',', ' ') . '<br>';
                                }


                                // Если единици измерения штуки (unit_id = 3) или порции (unit_id = 4) не учитываем вес этого элемента
                                if ($product["unit_id"] == '3' || $product["unit_id"] == '4') {

                                } else {
                                    $nakopit_item_amount = $nakopit_item_amount + $row["component_net"];
                                }
                                $nakopit_item_cost = $nakopit_item_cost + $pres_item_cost;
                                $nakopit_item_protein = $nakopit_item_protein + $pres_item_protein;
                                $nakopit_item_fat = $nakopit_item_fat + $pres_item_fat;
                                $nakopit_item_carbohydrate = $nakopit_item_carbohydrate + $pres_item_carbohydrate;
                                $nakopit_item_energy = $nakopit_item_energy + $pres_item_energy;


                                if ($edbutt == '1') {
                                    $collaps_block = $collaps_block . "
                                    <tr class='semi'>
                                        <td>" . $row['component_name'] . "</td>
                                        <td class='td-right'>" . number_format(($p_item_cost / $p_item_amount), 2, ',', ' ') . "</td>
                                        <td class='td-right'>" . number_format($row["component_gross"], 3, ',', ' ') . "</td>
                                        <td class='td-right'>" . number_format($row["component_net"], 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_amount, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($pres_item_cost, 2, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_cost, 2, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($pres_item_protein, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_protein, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($pres_item_fat, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_fat, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($pres_item_carbohydrate, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_carbohydrate, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($pres_item_energy, 3, ',', ' ') . "</td>
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
                                        <td class='td-right'>" . number_format(($p_item_cost / $p_item_amount), 2, ',', ' ') . "</td>
                                        <td class='td-right'>" . number_format($row["component_gross"], 3, ',', ' ') . "</td>
                                        <td class='td-right'>" . number_format($row["component_net"], 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_amount, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($pres_item_cost, 2, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_cost, 2, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($pres_item_protein, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_protein, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($pres_item_fat, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_fat, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($pres_item_carbohydrate, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_carbohydrate, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($pres_item_energy, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_energy, 3, ',', ' ') . ")</td>
                                        <td></td>
                                    </tr>
                                    ";
                                }

                            }

                            if ($row_reci_cnt > 0)
                            {
                                if ($diagnostics_tab == 'on')
                                {
                                    //     Диагностика данных о подсчёте пищевой ценности!
                                    echo "<br>";
                                    echo "<b style='color: green;'>" . $row['component_name'] . "</b>";
                                    echo "<b style='color: green;'> - это рецепт! </b><br>";
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

                            if ($row_prod_cnt == 0 && $row_semi_cnt == 0 && $row_pres_cnt == 0 && $row_reci_cnt == 0)
                            {
                                echo "<b style='color: orange;'>".$row['component_name']."</b>";
                                echo "<b style='color: orange;'> - а что это тогда? </b><br>";
                                $collaps_block = $collaps_block."
                                    <tr>
                                        <td>Что это?!</td>
                                        <td class='td-right'></td>
                                        <td class='td-right'></td>
                                        <td class='td-right'></td>
                                        <td class='td-right'></td>
                                        <td class='td-right'></td>
                                        <td class='td-right'></td>
                                        <td class='td-right'></td>
                                        <td class='td-right'></td>
                                        <td class='td-right'></td>
                                        <td class='td-right'></td>
                                        <td class='td-right'></td>
                                        <td class='td-right'></td>
                                        <td class='td-right'></td>
                                        <td class='td-right'></td>
                                        <td class='td-right'></td>
                                    </tr>
                                    ";
                            }
                        }
                    }
    
                    }





k/if ($npp !== 0)
{
$item_amount = $nakopit_item_amount;
$item_cost = $nakopit_item_cost;
$item_protein = $nakopit_item_protein;
$item_fat = $nakopit_item_fat;
$item_carbohydrate = $nakopit_item_carbohydrate;
$item_energy = $nakopit_item_energy;

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
}
$mysqli->close();

?>