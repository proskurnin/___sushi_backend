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

    if ($item_name_check !== $row[$tabname . '_name']) {
        if ($npp !== 0) {

            $item_net = $nakopit_item_net;
            $item_cost = $nakopit_item_cost;
            $item_protein = $nakopit_item_protein;
            $item_fat = $nakopit_item_fat;
            $item_carbohydrate = $nakopit_item_carbohydrate;
            $item_energy = $nakopit_item_energy;

            if ($nutr_val == '1') {
                $nutr = $item_net / 0.1;
            } else {
                $nutr = 1;
            }

            $item_protein = $item_protein / $nutr;
            $item_fat = $item_fat / $nutr;
            $item_carbohydrate = $item_carbohydrate / $nutr;
            $item_energy = $item_energy / $nutr;

            echo "
        <tr>
            <td>" . $npp . "</td>
            <td>" . $item_name . "</td>
            <td class='td-right'>" . number_format($item_net, 3, ',', ' ') . "</td>
            <td class='td-right'>" . number_format($item_cost, 2, ',', ' ') . "</td>
            <td class='td-right'>" . number_format($item_protein, 3, ',', ' ') . "</td>
            <td class='td-right'>" . number_format($item_fat, 3, ',', ' ') . "</td>
            <td class='td-right'>" . number_format($item_carbohydrate, 3, ',', ' ') . "</td>
            <td class='td-right'>" . number_format($item_energy, 3, ',', ' ') . "</td>";
            if ($edbutt == '1') {
                echo "
            <td class='td-right'>
                <!-- Button trigger modal -->
                <a data-toggle='collapse' href='#collapse_" . $npp . "' aria-expanded='false' aria-controls='collapse_" . $npp . "'>
                    <i class='fa fa-info-circle' aria-hidden='true'></i></a>
        
                &nbsp;&nbsp;
        
                <a name='del' href=" . $urlform . "?del=" . urlencode($item_name) . " onclick ='return confirm(\"Удалить {$item_name}?\")'>
                    <i class='fa fa-trash-o' aria-hidden='true' style='color: red;'></i></a>
        
                &nbsp;&nbsp;
        
                <a name='edit' href=" . $urlform . "?editrow=editrow&edit_name=" . urlencode($item_name) . ">
                    <i class='fa fa-pencil-square-o' aria-hidden='true' style='color: cornflowerblue;'></i></a>
            </td>
            ";
            }
            echo "
        </tr>";

            $collaps_block = $collaps_block . "
        </tbody>
        </table>
        </div>
        </td>
        </tr>
        ";

            echo $collaps_block;

            $nakopit_item_gros = 0;
            $nakopit_item_net = 0;
            $nakopit_item_cost = 0;
            $nakopit_item_protein = 0;
            $nakopit_item_fat = 0;
            $nakopit_item_carbohydrate = 0;
            $nakopit_item_energy = 0;
        }

        $npp++;

        $collaps_block = "<tr class='infoblock'><td colspan='9'>
            <div class='collapse' id='collapse_" . $npp . "'>
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

        $item_net = 0;
        $item_cost = 0;
        $item_protein = 0;
        $item_fat = 0;
        $item_carbohydrate = 0;
        $item_energy = 0;
    }

    $prod_item_cost = 0;
    $prod_item_protein = 0;
    $prod_item_fat = 0;
    $prod_item_carbohydrate = 0;
    $prod_item_energy = 0;

    $semi_item_cost = 0;
    $semi_item_protein = 0;
    $semi_item_fat = 0;
    $semi_item_carbohydrate = 0;
    $semi_item_energy = 0;

    $pres_item_gros = 0;
    $pres_item_net = 0;
    $pres_item_cost = 0;
    $pres_item_protein = 0;
    $pres_item_fat = 0;
    $pres_item_carbohydrate = 0;
    $pres_item_energy = 0;

    $reci_item_gros = 0;
    $reci_item_net = 0;
    $reci_item_cost = 0;
    $reci_item_protein = 0;
    $reci_item_fat = 0;
    $reci_item_carbohydrate = 0;
    $reci_item_energy = 0;

    $item_name = $row[$tabname . '_name'];
    $item_name_check = $row[$tabname . '_name'];

    $query_prod = "SELECT * FROM `products` WHERE  `product_name` = '" . $row['component_name'] . "'";
    $query_semi = "SELECT * FROM `semis` WHERE  `semi_name` = '" . $row['component_name'] . "'";
    $query_pres = "SELECT * FROM `presets` WHERE  `preset_name` = '" . $row['component_name'] . "'";
    $query_reci = "SELECT * FROM `recipes` WHERE  `recipe_name` = '" . $row['component_name'] . "'";

    foreach ($row as $k => $v) {

        if (($k == $tabname . '_name') && ($v == $item_name)) {
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


            if ($row_prod_cnt > 0) {

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
                    $prod_item_net = $prod_item_net + $row["component_net"];
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
                                AND `product_name` = '" . $item_name . "'";
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
                                AND `product_name` = '" . $item_name . "'";
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


                $prod_item_cost = $prod_item_cost + $row["component_gross"] * $price_online;
                $prod_item_protein = $prod_item_protein + $row["component_net"] * $product["protein"] / 0.1;
                $prod_item_fat = $prod_item_fat + $row["component_net"] * $product["fat"] / 0.1;
                $prod_item_carbohydrate = $prod_item_carbohydrate + $row["component_net"] * $product["carbohydrate"] / 0.1;
                $prod_item_energy = $prod_item_energy + $row["component_net"] * $product["energy"] / 0.1;

                if ($diagnostics_tab == 'on') {
                    //     Диагностика данных о подсчёте пищевой ценности!
                    echo '<b style="color: #00c1cd;">цена: </b>' . number_format(($row["component_gross"] * $price_online), 2, ',', ' ') . ' (' . number_format($prod_item_cost, 2, ',', ' ') . ') : ';
                    echo '<b style="color: #00c1cd;">кол: </b>' . number_format(($row["component_net"]), 3, ',', ' ') . ' (' . number_format($prod_item_net, 3, ',', ' ') . ') : ';
                    echo '<b style="color: #00c1cd;">белок: </b>' . number_format((($row["component_net"] * $product["protein"]) / 0.1), 3, ',', ' ') . ' (' . number_format($prod_item_protein, 3, ',', ' ') . ') : ';
                    echo '<b style="color: #00c1cd;">жир: </b>' . number_format((($row["component_net"] * $product["fat"]) / 0.1), 3, ',', ' ') . ' (' . number_format($prod_item_fat, 3, ',', ' ') . ') : ';
                    echo '<b style="color: #00c1cd;">углев: </b>' . number_format((($row["component_net"] * $product["carbohydrate"]) / 0.1), 3, ',', ' ') . ' (' . number_format($prod_item_carbohydrate, 3, ',', ' ') . ') : ';
                    echo '<b style="color: #00c1cd;">энерг: </b>' . number_format((($row["component_net"] * $product["energy"]) / 0.1), 3, ',', ' ') . ' (' . number_format($prod_item_energy, 3, ',', ' ') . ') <br>';
                }

                // Если единици измерения штуки (unit_id = 3) или порции (unit_id = 4) не учитываем вес этого элемента
                if ($product["unit_id"] == '3' || $product["unit_id"] == '4') {

                } else {
                    $nakopit_item_net = $nakopit_item_net + $row["component_net"];
                }
                $nakopit_item_cost = $nakopit_item_cost + $row["component_gross"] * $price_online;
                $nakopit_item_protein = $nakopit_item_protein + $row["component_net"] * $product["protein"] / 0.1;
                $nakopit_item_fat = $nakopit_item_fat + $row["component_net"] * $product["fat"] / 0.1;
                $nakopit_item_carbohydrate = $nakopit_item_carbohydrate + $row["component_net"] * $product["carbohydrate"] / 0.1;
                $nakopit_item_energy = $nakopit_item_energy + $row["component_net"] * $product["energy"] / 0.1;


                $collaps_block = $collaps_block . "
                                <tr>
                                    <td>" . $row['component_name'] . "</td>
                                    <td class='td-right'>" . number_format($price_online, 2, ',', ' ') . "</td>
                                    <td class='td-right'>" . number_format($row["component_gross"], 3, ',', ' ') . "</td>
                                    <td class='td-right'>" . number_format($row["component_net"], 3, ',', ' ') . "</td>
                                    <td class='nakopit'>(" . number_format($nakopit_item_net, 3, ',', ' ') . ")</td>
                
                                    <td class='td-right'>" . number_format(($row["component_gross"] * $price_online), 2, ',', ' ') . "</td>
                                    <td class='nakopit'>(" . number_format($nakopit_item_cost, 2, ',', ' ') . ")</td>
                
                                    <td class='td-right'>" . number_format((($row["component_net"] * $product["protein"]) / 0.1), 3, ',', ' ') . "</td>
                                    <td class='nakopit'>(" . number_format($nakopit_item_protein, 3, ',', ' ') . ")</td>
                
                                    <td class='td-right'>" . number_format((($row["component_net"] * $product["fat"]) / 0.1), 3, ',', ' ') . "</td>
                                    <td class='nakopit'>(" . number_format($nakopit_item_fat, 3, ',', ' ') . ")</td>
                
                                    <td class='td-right'>" . number_format((($row["component_net"] * $product["carbohydrate"]) / 0.1), 3, ',', ' ') . "</td>
                                    <td class='nakopit'>(" . number_format($nakopit_item_carbohydrate, 3, ',', ' ') . ")</td>
                
                                    <td class='td-right'>" . number_format((($row["component_net"] * $product["energy"]) / 0.1), 3, ',', ' ') . "</td>
                                    <td class='nakopit'>(" . number_format($nakopit_item_energy, 3, ',', ' ') . ")</td>
                                    
                                    <td></td>
                                </tr>
                                ";
            }

            if ($row_semi_cnt > 0) {
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

                $s_item_net = 0;
                $s_item_cost = 0;
                $s_item_protein = 0;
                $s_item_fat = 0;
                $s_item_carbohydrate = 0;
                $s_item_energy = 0;

                while (($semi_row = $dbsemi->fetch_assoc()) != false) {

                    $semi_item_name = $semi_row['semi_name'];
                    //                            $item_name_check = $semi_row['semi_name'];

                    $query = "SELECT * FROM `products` WHERE  `product_name` = '" . $semi_row['component_name'] . "'";

                    foreach ($semi_row as $k => $v) {

                        if (($k == 'semi_name') && ($v == $semi_item_name)) {

                            if ($diagnostics_tab == 'on') {
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
                                            AND `product_name` = '" . $item_name . "'";
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
                                            AND `product_name` = '" . $item_name . "'";
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


                            // Если единици измерения штуки (unit_id = 3) или порции (unit_id = 4) не учитываем вес этого элемента
                            if ($product["unit_id"] == '3' || $product["unit_id"] == '4') {
                            } else {
                                $s_item_net = $s_item_net + $semi_row["component_net"];
                            }

                            $s_item_cost = $s_item_cost + $semi_row["component_gross"] * $price_online;
                            $s_item_protein = $s_item_protein + $semi_row["component_net"] * $product["protein"];
                            $s_item_fat = $s_item_fat + $semi_row["component_net"] * $product["fat"];
                            $s_item_carbohydrate = $s_item_carbohydrate + $semi_row["component_net"] * $product["carbohydrate"];
                            $s_item_energy = $s_item_energy + $semi_row["component_net"] * $product["energy"];


                            // НЕ СДЕЛАН БЛОК !!!
                            // Должен быть блок разворачивания состава полуфабриката (i)
                            // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
                            $collaps_sub_block = $collaps_sub_block . "
                                        <tr>
                                            <td>" . $semi_row['component_name'] . "</td>
                                            <td class='td-right'>" . number_format($price_online, 2, ',', ' ') . "</td>
                                            <td class='td-right'>" . number_format($semi_row["component_gross"], 3, ',', ' ') . "</td>
                                            <td class='td-right'>" . number_format($semi_row["component_net"], 3, ',', ' ') . "</td>
                                            <td class='nakopit'>(" . number_format($nakopit_item_net, 3, ',', ' ') . ")</td>
                        
                                            <td class='td-right'>" . number_format(($semi_row["component_gross"] * $price_online), 2, ',', ' ') . "</td>
                                            <td class='nakopit'>(" . number_format($nakopit_item_cost, 2, ',', ' ') . ")</td>
                        
                                            <td class='td-right'>" . number_format((($semi_row["component_net"] * $product["protein"]) / 0.1), 3, ',', ' ') . "</td>
                                            <td class='nakopit'>(" . number_format($nakopit_item_protein, 3, ',', ' ') . ")</td>
                        
                                            <td class='td-right'>" . number_format((($semi_row["component_net"] * $product["fat"]) / 0.1), 3, ',', ' ') . "</td>
                                            <td class='nakopit'>(" . number_format($nakopit_item_fat, 3, ',', ' ') . ")</td>
                        
                                            <td class='td-right'>" . number_format((($semi_row["component_net"] * $product["carbohydrate"]) / 0.1), 3, ',', ' ') . "</td>
                                            <td class='nakopit'>(" . number_format($nakopit_item_carbohydrate, 3, ',', ' ') . ")</td>
                        
                                            <td class='td-right'>" . number_format((($semi_row["component_net"] * $product["energy"]) / 0.1), 3, ',', ' ') . "</td>
                                            <td class='nakopit'>(" . number_format($nakopit_item_energy, 3, ',', ' ') . ")</td>
                                            
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
                    echo '<b style="color: #0000cd;">кол: </b>' . number_format($s_item_net, 3, ',', ' ') . ' : ';
                    echo '<b style="color: #0000cd;">белок: </b>' . number_format($s_item_protein, 3, ',', ' ') . ' : ';
                    echo '<b style="color: #0000cd;">жир: </b>' . number_format($s_item_fat, 3, ',', ' ') . ' : ';
                    echo '<b style="color: #0000cd;">углев: </b>' . number_format($s_item_carbohydrate, 3, ',', ' ') . ' : ';
                    echo '<b style="color: #0000cd;">энерг: </b>' . number_format($s_item_energy, 3, ',', ' ') . '<br>';
                }

                $semi_item_cost = $s_item_cost / $s_item_net * $row["component_gross"];
                $semi_item_protein = $s_item_protein / $s_item_net * $row["component_net"];
                $semi_item_fat = $s_item_fat / $s_item_net * $row["component_net"];
                $semi_item_carbohydrate = $s_item_carbohydrate / $s_item_net * $row["component_net"];
                $semi_item_energy = $s_item_energy / $s_item_net * $row["component_net"];
                $semi_item_net = $s_item_net / $s_item_net * $row["component_net"];

                if ($diagnostics_tab == 'on') {
                    //     Диагностика данных о подсчёте пищевой ценности!
                    echo '<b style="color: #00c1cd;">Показатель эн.ценности на ' . number_format($semi_item_net, 3, ',', ' ') . ' кг.: </b><br>';

                    echo '<b style="color: #00c1cd;">цена: </b>' . number_format($semi_item_cost, 2, ',', ' ') . ' : ';
                    echo '<b style="color: #00c1cd;">кол: </b>' . number_format($semi_item_net, 3, ',', ' ') . ' : ';
                    echo '<b style="color: #00c1cd;">белок: </b>' . number_format($semi_item_protein, 3, ',', ' ') . ' : ';
                    echo '<b style="color: #00c1cd;">жир: </b>' . number_format($semi_item_fat, 3, ',', ' ') . ' : ';
                    echo '<b style="color: #00c1cd;">углев: </b>' . number_format($semi_item_carbohydrate, 3, ',', ' ') . ' : ';
                    echo '<b style="color: #00c1cd;">энерг: </b>' . number_format($semi_item_energy, 3, ',', ' ') . '<br>';
                }

                // Если единици измерения штуки (unit_id = 3) или порции (unit_id = 4) не учитываем вес этого элемента
                if ($product["unit_id"] == '3' || $product["unit_id"] == '4') {

                } else {
                    $nakopit_item_net = $nakopit_item_net + $row["component_net"];
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
                                        <td class='td-right'>" . number_format(($s_item_cost / $s_item_net), 2, ',', ' ') . "</td>
                                        <td class='td-right'>" . number_format($row["component_gross"], 3, ',', ' ') . "</td>
                                        <td class='td-right'>" . number_format($row["component_net"], 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_net, 3, ',', ' ') . ")</td>
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
                }

            }

            if ($row_pres_cnt > 0) {

                if ($diagnostics_tab == 'on') {
                    //     Диагностика данных о подсчёте пищевой ценности!
                    echo "<br>";
                    echo "<b style='color: green;'>" . $row['component_name'] . "</b>";
                    echo "<b style='color: green;'> - это комплект! </b><br>";
                    echo '<b style="color: red;">имя: </b>' . $row["component_name"] . ' : ';
                    echo '<b style="color: red;">количество: </b>' . $row["component_amount"] . '<br>';
                    echo '<b style="color: blue;">Единица комплекта состоит из: </b><br>';
                }

                $p_item_gross = 0;
                $p_item_net = 0;
                $p_item_cost = 0;
                $p_item_protein = 0;
                $p_item_fat = 0;
                $p_item_carbohydrate = 0;
                $p_item_energy = 0;

                while (($pres_row = $dbpres->fetch_assoc()) != false) {

                    $pres_item_name = $pres_row['preset_name'];
                    $query = "SELECT * FROM `presets` WHERE  `preset_name` = '" . $pres_row['component_name'] . "'";

                    $query_prod = "SELECT * FROM `products` WHERE  `product_name` = '" . $pres_row['component_name'] . "'";
                    $dbproduct = $mysqli->query($query_prod) or die($query_prod);
                    $product = $dbproduct->fetch_assoc();

                    foreach ($pres_row as $k => $v) {

                        if (($k == 'preset_name') && ($v == $pres_item_name)) {

                            if ($diagnostics_tab == 'on') {
                                //     Диагностика данных о подсчёте пищевой ценности!
                                echo '<b style="color: blue;">имя: </b>' . $pres_row["component_name"] . ' : ';
                                echo '<b style="color: blue;">брутто: </b>' . $pres_row["component_gross"] . ' : ';
                                echo '<b style="color: blue;">нетто: </b>' . $pres_row["component_net"] . ' : ';
                                echo '<b style="color: blue;">стоим: </b>' . $pres_row["component_gross"] * $price_online . ' : ';
                                echo '<b style="color: blue;">белк: </b>' . $pres_row["component_net"] * $product["protein"] / 0.1 . ' : ';
                                echo '<b style="color: blue;">жиры: </b>' . $pres_row["component_net"] * $product["fat"] / 0.1 . ' : ';
                                echo '<b style="color: blue;">углев: </b>' . $pres_row["component_net"] * $product["carbohydrate"] / 0.1 . ' : ';
                                echo '<b style="color: blue;">эн.цен.: </b>' . $pres_row["component_net"] * $product["energy"] / 0.1 . '<br>';

//                                echo '$product["protein"] = '.$product["protein"].'<br>';
//                                echo '$product["fat"] = '.$product["fat"].'<br>';
//                                echo '$product["carbohydrate"] = '.$product["carbohydrate"].'<br>';
//                                echo '$product["energy"] = '.$product["energy"].'<br>';


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
                                            AND `product_name` = '" . $item_name . "'";
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
                                            AND `product_name` = '" . $item_name . "'";
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


                            // Если единици измерения штуки (unit_id = 3) или порции (unit_id = 4) не учитываем вес этого элемента
                            if ($product["unit_id"] == '3' || $product["unit_id"] == '4') {
                            } else {
                                $p_item_gross = $p_item_gross + $pres_row["component_gross"];
                                $p_item_net = $p_item_net + $pres_row["component_net"];
                            }
                            $p_item_cost = $p_item_cost + $pres_row["component_gross"] * $price_online;
                            $p_item_protein = $p_item_protein + $pres_row["component_net"] * $product["protein"] / 0.1;
                            $p_item_fat = $p_item_fat + $pres_row["component_net"] * $product["fat"] / 0.1;
                            $p_item_carbohydrate = $p_item_carbohydrate + $pres_row["component_net"] * $product["carbohydrate"] / 0.1;
                            $p_item_energy = $p_item_energy + $pres_row["component_net"] * $product["energy"] / 0.1;


                            // НЕ СДЕЛАН БЛОК !!!
                            // Должен быть блок разворачивания состава полуфабриката (i)
                            // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
                            $collaps_sub_block = $collaps_sub_block . "
                                        <tr>
                                            <td>" . $pres_row['component_name'] . "</td>
                                            <td class='td-right'>" . number_format($price_online, 2, ',', ' ') . "</td>
                                            <td class='td-right'>" . number_format($pres_row["component_gross"], 3, ',', ' ') . "</td>
                                            <td class='td-right'>" . number_format($pres_row["component_net"], 3, ',', ' ') . "</td>
                                            <td class='nakopit'>(" . number_format($nakopit_item_net, 3, ',', ' ') . ")</td>
                        
                                            <td class='td-right'>" . number_format(($pres_row["component_gross"] * $price_online), 2, ',', ' ') . "</td>
                                            <td class='nakopit'>(" . number_format($nakopit_item_cost, 2, ',', ' ') . ")</td>
                        
                                            <td class='td-right'>" . number_format((($pres_row["component_net"] * $product["protein"]) / 0.1), 3, ',', ' ') . "</td>
                                            <td class='nakopit'>(" . number_format($nakopit_item_protein, 3, ',', ' ') . ")</td>
                        
                                            <td class='td-right'>" . number_format((($pres_row["component_net"] * $product["fat"]) / 0.1), 3, ',', ' ') . "</td>
                                            <td class='nakopit'>(" . number_format($nakopit_item_fat, 3, ',', ' ') . ")</td>
                        
                                            <td class='td-right'>" . number_format((($pres_row["component_net"] * $product["carbohydrate"]) / 0.1), 3, ',', ' ') . "</td>
                                            <td class='nakopit'>(" . number_format($nakopit_item_carbohydrate, 3, ',', ' ') . ")</td>
                        
                                            <td class='td-right'>" . number_format((($presets_row["component_net"] * $product["energy"]) / 0.1), 3, ',', ' ') . "</td>
                                            <td class='nakopit'>(" . number_format($nakopit_item_energy, 3, ',', ' ') . ")</td>
                                            
                                            <td></td>
                                        </tr>
                                        ";
                            // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

                        }

                    }
                }

                if ($diagnostics_tab == 'on') {
                    //     Диагностика данных о подсчёте пищевой ценности!
                    echo '<b style="color: blue;">Показатель на еденицу полуфабриката: </b><br>';

                    echo '<b style="color: blue;">цена: </b>' . number_format($p_item_cost, 2, ',', ' ') . ' : ';
                    echo '<b style="color: blue;">брутто: </b>' . number_format($p_item_gross, 3, ',', ' ') . ' : ';
                    echo '<b style="color: blue;">нетто: </b>' . number_format($p_item_net, 3, ',', ' ') . ' : ';
                    echo '<b style="color: blue;">белок: </b>' . number_format($p_item_protein, 3, ',', ' ') . ' : ';
                    echo '<b style="color: blue;">жир: </b>' . number_format($p_item_fat, 3, ',', ' ') . ' : ';
                    echo '<b style="color: blue;">углев: </b>' . number_format($p_item_carbohydrate, 3, ',', ' ') . ' : ';
                    echo '<b style="color: blue;">энерг: </b>' . number_format($p_item_energy, 3, ',', ' ') . '<br>';
                }

                $pres_item_gross = $p_item_gross * $row["component_amount"];
                $pres_item_net = $p_item_net * $row["component_amount"];
                $pres_item_cost = $p_item_cost * $row["component_amount"];
                $pres_item_protein = $p_item_protein * $row["component_amount"];
                $pres_item_fat = $p_item_fat * $row["component_amount"];
                $pres_item_carbohydrate = $p_item_carbohydrate * $row["component_amount"];
                $pres_item_energy = $p_item_energy * $row["component_amount"];

                if ($diagnostics_tab == 'on') {
                    //     Диагностика данных о подсчёте пищевой ценности!
                    echo '<b style="color: #000087;">Показатели комплекта на ' . number_format($row["component_amount"], 3, ',', ' ') . ' ед.: </b><br>';

                    echo '<b style="color: #000087;">цена: </b>' . number_format($pres_item_cost, 2, ',', ' ') . ' : ';
                    echo '<b style="color: #000087;">брутто: </b>' . number_format($pres_item_gross, 3, ',', ' ') . ' : ';
                    echo '<b style="color: #000087;">нетто: </b>' . number_format($pres_item_net, 3, ',', ' ') . ' : ';
                    echo '<b style="color: #000087;">белок: </b>' . number_format($pres_item_protein, 3, ',', ' ') . ' : ';
                    echo '<b style="color: #000087;">жир: </b>' . number_format($pres_item_fat, 3, ',', ' ') . ' : ';
                    echo '<b style="color: #000087;">углев: </b>' . number_format($pres_item_carbohydrate, 3, ',', ' ') . ' : ';
                    echo '<b style="color: #000087;">энерг: </b>' . number_format($pres_item_energy, 3, ',', ' ') . '<br>';
                }

                $nakopit_item_gros = $nakopit_item_gros + $pres_item_gros;
                $nakopit_item_net = $nakopit_item_net + $pres_item_net;
                $nakopit_item_cost = $nakopit_item_cost + $pres_item_cost;
                $nakopit_item_protein = $nakopit_item_protein + $pres_item_protein;
                $nakopit_item_fat = $nakopit_item_fat + $pres_item_fat;
                $nakopit_item_carbohydrate = $nakopit_item_carbohydrate + $pres_item_carbohydrate;
                $nakopit_item_energy = $nakopit_item_energy + $pres_item_energy;

                if ($edbutt == '1') {
                    $collaps_block = $collaps_block . "
                                    <tr class='presets'>
                                        <td>" . $row['component_name'] . "</td>
                                        <td class='td-right'>" . number_format($pres_item_cost, 2, ',', ' ') . "</td>
                                        <td class='td-right'>" . number_format($pres_item_gross, 3, ',', ' ') . "</td>
                                        <td class='td-right'>" . number_format($pres_item_net, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_net, 3, ',', ' ') . ")</td>
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
                }
            }

            if ($row_reci_cnt > 0) {
                if ($diagnostics_tab == 'on') {
                    //     Диагностика данных о подсчёте пищевой ценности!
                    echo "<br>";
                    echo "<b style='color: green;'>" . $row['component_name'] . "</b>";
                    echo "<b style='color: green;'> - это рецепт! </b><br>";
                    echo '<b style="color: red;">имя рецепта: </b>' . $row["component_name"] . ' : ';
                    echo '<b style="color: red;">количество в блюде: </b>' . $row["component_amount"] . '<br>';
                    echo '<b style="color: blue;">Единица рецепта состоит из: </b><br>';
                }

                $r_item_gross = 0;
                $r_item_net = 0;
                $r_item_cost = 0;
                $r_item_protein = 0;
                $r_item_fat = 0;
                $r_item_carbohydrate = 0;
                $r_item_energy = 0;

                while (($reci_row = $dbreci->fetch_assoc()) != false) {

                    $reci_item_name = $reci_row['recipe_name'];
                    $query = "SELECT * FROM `recipes` WHERE  `recipe_name` = '" . $reci_row['component_name'] . "'";

                    $query_prod = "SELECT * FROM `products` WHERE  `product_name` = '" . $reci_row['component_name'] . "'";
                    $dbproduct = $mysqli->query($query_prod) or die($query_prod);
                    $product = $dbproduct->fetch_assoc();

                    $query_semi = "SELECT * FROM `semis` WHERE  `semi_name` = '" . $reci_row['component_name'] . "'";

                    foreach ($reci_row as $k => $v) {

                        if (($k == 'recipe_name') && ($v == $reci_item_name)) {

                            $dbsemi = $mysqli->query($query_semi) or die($query_semi);
                            /* определение числа рядов в выборке полуфабрикатов */
                            $row_semi_cnt = mysqli_num_rows($dbsemi);

                            if ($row_semi_cnt > 0)
                            {
                                if ($diagnostics_tab == 'on') {
                                    //     Диагностика данных о подсчёте пищевой ценности!
                                    echo '<b style="color: #84bfff;">&nbsp;&nbsp;&nbsp;&nbsp;Полуфабрикат: </b>' . $reci_row["component_name"] . '<br>';
                                    echo '<b style="color: #84bfff;">&nbsp;&nbsp;&nbsp;&nbsp;состоит из: </b><br>';
                                }

                                $s_item_net = 0;
                                $s_item_cost = 0;
                                $s_item_protein = 0;
                                $s_item_fat = 0;
                                $s_item_carbohydrate = 0;
                                $s_item_energy = 0;

                                while (($semi_row = $dbsemi->fetch_assoc()) != false) {

                                    $semi_item_name = $semi_row['semi_name'];
                                    $query = "SELECT * FROM `products` WHERE  `product_name` = '" . $semi_row['component_name'] . "'";

                                    foreach ($semi_row as $k => $v) {

                                        if (($k == 'semi_name') && ($v == $semi_item_name)) {

                                            if ($diagnostics_tab == 'on') {
                                                //     Диагностика данных о подсчёте пищевой ценности!
                                                echo '<b style="color: #84bfff;">&nbsp;&nbsp;&nbsp;&nbsp;имя: </b>' . $semi_row["component_name"] . ' : ';
                                                echo '<b style="color: #84bfff;">брутто: </b>' . $semi_row["component_gross"] . ' : ';
                                                echo '<b style="color: #84bfff;">нетто: </b>' . $semi_row["component_net"] . ' : ';
                                                echo '<b style="color: #84bfff;">стоим: </b>' . $semi_row["component_gross"] * $price_online . ' : ';
                                                echo '<b style="color: #84bfff;">белк: </b>' . $semi_row["component_net"] * $product["protein"] / 0.1 . ' : ';
                                                echo '<b style="color: #84bfff;">жиры: </b>' . $semi_row["component_net"] * $product["fat"] / 0.1 . ' : ';
                                                echo '<b style="color: #84bfff;">углев: </b>' . $semi_row["component_net"] * $product["carbohydrate"] / 0.1 . ' : ';
                                                echo '<b style="color: #84bfff;">эн.цен.: </b>' . $semi_row["component_net"] * $product["energy"] / 0.1 . '<br>';
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
                                            AND `product_name` = '" . $item_name . "'";
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
                                            AND `product_name` = '" . $item_name . "'";
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


                                            // Если единици измерения штуки (unit_id = 3) или порции (unit_id = 4) не учитываем вес этого элемента
                                            if ($product["unit_id"] == '3' || $product["unit_id"] == '4') {
                                            } else {
                                                $s_item_net = $s_item_net + $semi_row["component_net"];
                                            }

                                            $s_item_cost = $s_item_cost + $semi_row["component_gross"] * $price_online;
                                            $s_item_protein = $s_item_protein + $semi_row["component_net"] * $product["protein"];
                                            $s_item_fat = $s_item_fat + $semi_row["component_net"] * $product["fat"];
                                            $s_item_carbohydrate = $s_item_carbohydrate + $semi_row["component_net"] * $product["carbohydrate"];
                                            $s_item_energy = $s_item_energy + $semi_row["component_net"] * $product["energy"];

                                        }
                                    }
                                }

                                $semi_item_cost = $s_item_cost / $s_item_net * $reci_row["component_gross"];
                                $semi_item_protein = $s_item_protein / $s_item_net * $reci_row["component_net"];
                                $semi_item_fat = $s_item_fat / $s_item_net * $reci_row["component_net"];
                                $semi_item_carbohydrate = $s_item_carbohydrate / $s_item_net * $reci_row["component_net"];
                                $semi_item_energy = $s_item_energy / $s_item_net * $reci_row["component_net"];
                                $semi_item_net = $s_item_net / $s_item_net * $reci_row["component_net"];

                                if ($diagnostics_tab == 'on') {
                                    //     Диагностика данных о подсчёте пищевой ценности!
                                    echo '<b style="color: blue;">имя: </b>' . $reci_row["component_name"] . ' : ';
                                    echo '<b style="color: blue;">брутто: </b>' . number_format($reci_row["component_gross"], 4, ',', ' ') . ' : ';
                                    echo '<b style="color: blue;">нетто: </b>' . number_format($semi_item_net, 4, ',', ' ') . ' : ';
                                    echo '<b style="color: blue;">стоим: </b>' . number_format($semi_item_cost, 2, ',', ' ') . ' : ';
                                    echo '<b style="color: blue;">белок: </b>' . number_format($semi_item_protein, 3, ',', ' ') . ' : ';
                                    echo '<b style="color: blue;">жир: </b>' . number_format($semi_item_fat, 3, ',', ' ') . ' : ';
                                    echo '<b style="color: blue;">углев: </b>' . number_format($semi_item_carbohydrate, 3, ',', ' ') . ' : ';
                                    echo '<b style="color: blue;">энерг: </b>' . number_format($semi_item_energy, 3, ',', ' ') . '<br>';
                                }

                                $reci_item_gros = $reci_item_gros + $reci_row["component_gross"];
                                $reci_item_net = $reci_item_net + $reci_row["component_net"];
                                $reci_item_cost = $reci_item_cost + $semi_item_cost;
                                $reci_item_protein = $reci_item_protein + $semi_item_protein;
                                $reci_item_fat = $reci_item_fat + $semi_item_fat;
                                $reci_item_carbohydrate = $reci_item_carbohydrate + $semi_item_carbohydrate;
                                $reci_item_energy = $reci_item_energy + $semi_item_energy;

                            }
                            else
                            {

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
                                            AND `product_name` = '" . $item_name . "'";
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
                                            AND `product_name` = '" . $item_name . "'";
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


                                // Если единици измерения штуки (unit_id = 3) или порции (unit_id = 4) не учитываем вес этого элемента
                                if ($product["unit_id"] == '3' || $product["unit_id"] == '4') {
                                    $r_item_gros = 0;
                                    $r_item_net = 0;
                                } else {
                                    $r_item_gros = $reci_row["component_gross"];
                                    $r_item_net = $reci_row["component_net"];
                                }
                                $r_item_cost =  $reci_row["component_gross"] * $price_online;
                                $r_item_protein =  $reci_row["component_net"] * $product["protein"] / 0.1;
                                $r_item_fat =  $reci_row["component_net"] * $product["fat"] / 0.1;
                                $r_item_carbohydrate = $reci_row["component_net"] * $product["carbohydrate"] / 0.1;
                                $r_item_energy = $reci_row["component_net"] * $product["energy"] / 0.1;

                                if ($diagnostics_tab == 'on') {
                                    //     Диагностика данных о подсчёте пищевой ценности!
                                    echo '<b style="color: blue;">имя: </b>' . $reci_row["component_name"] . ' : ';
                                    echo '<b style="color: blue;">бр: </b>' . $reci_row["component_gross"] . ' : ';
                                    echo '<b style="color: blue;">нт: </b>' . $reci_row["component_net"] . ' : ';
                                    echo '<b style="color: blue;">ст: </b>' . $r_item_cost . ' : ';
                                    echo '<b style="color: blue;">б: </b>' . $r_item_protein . ' : ';
                                    echo '<b style="color: blue;">ж: </b>' . $r_item_fat . ' : ';
                                    echo '<b style="color: blue;">у: </b>' . $r_item_carbohydrate . ' : ';
                                    echo '<b style="color: blue;">э.: </b>' . $r_item_energy . '<br>';
                                }

                                $reci_item_gros = $reci_item_gros + $r_item_gros;
                                $reci_item_net = $reci_item_net + $r_item_net;
                                $reci_item_cost = $reci_item_cost + $r_item_cost;
                                $reci_item_protein = $reci_item_protein + $r_item_protein;
                                $reci_item_fat = $reci_item_fat + $r_item_fat;
                                $reci_item_carbohydrate = $reci_item_carbohydrate + $r_item_carbohydrate;
                                $reci_item_energy = $reci_item_energy + $r_item_energy;

                            }
                        }
                    }

                }

                if ($diagnostics_tab == 'on') {
                    //     Диагностика данных о подсчёте пищевой ценности!
                    echo '<b style="color: #000087;">Показатели рецепта на ' . number_format($row["component_amount"], 3, ',', ' ') . ' ед.: </b><br>';

                    echo '<b style="color: #000087;">цена: </b>' . number_format($reci_item_cost, 2, ',', ' ') . ' : ';
                    echo '<b style="color: #000087;">брутто: </b>' . number_format($reci_item_gros, 3, ',', ' ') . ' : ';
                    echo '<b style="color: #000087;">нетто: </b>' . number_format($reci_item_net, 3, ',', ' ') . ' : ';
                    echo '<b style="color: #000087;">белок: </b>' . number_format($reci_item_protein, 3, ',', ' ') . ' : ';
                    echo '<b style="color: #000087;">жир: </b>' . number_format($reci_item_fat, 3, ',', ' ') . ' : ';
                    echo '<b style="color: #000087;">углев: </b>' . number_format($reci_item_carbohydrate, 3, ',', ' ') . ' : ';
                    echo '<b style="color: #000087;">энерг: </b>' . number_format($reci_item_energy, 3, ',', ' ') . '<br>';
                }

                $nakopit_item_gros = $nakopit_item_gros + $reci_item_gros;
                $nakopit_item_net = $nakopit_item_net + $reci_item_net;
                $nakopit_item_cost = $nakopit_item_cost + $reci_item_cost;
                $nakopit_item_protein = $nakopit_item_protein + $reci_item_protein;
                $nakopit_item_fat = $nakopit_item_fat + $reci_item_fat;
                $nakopit_item_carbohydrate = $nakopit_item_carbohydrate + $reci_item_carbohydrate;
                $nakopit_item_energy = $nakopit_item_energy + $reci_item_energy;

                $nakopit_item_gros = $nakopit_item_gros * $row["component_amount"];
                $nakopit_item_net = $nakopit_item_net * $row["component_amount"];
                $nakopit_item_cost = $nakopit_item_cost * $row["component_amount"];
                $nakopit_item_protein = $nakopit_item_protein * $row["component_amount"];
                $nakopit_item_fat = $nakopit_item_fat * $row["component_amount"];
                $nakopit_item_carbohydrate = $nakopit_item_carbohydrate * $row["component_amount"];
                $nakopit_item_energy = $nakopit_item_energy * $row["component_amount"];

                if ($edbutt == '1') {
                    $collaps_block = $collaps_block . "
                                    <tr class='recipes'>
                                        <td>" . $row['component_name'] . "</td>
                                        <td class='td-right'>" . number_format($reci_item_cost, 2, ',', ' ') . "</td>
                                        <td class='td-right'>" . number_format($reci_item_gros, 3, ',', ' ') . "</td>
                                        <td class='td-right'>" . number_format($reci_item_net, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_net, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($reci_item_cost, 2, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_cost, 2, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($reci_item_protein, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_protein, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($reci_item_fat, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_fat, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($reci_item_carbohydrate, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_carbohydrate, 3, ',', ' ') . ")</td>
                                        <td class='td-right'>" . number_format($reci_item_energy, 3, ',', ' ') . "</td>
                                        <td class='nakopit'>(" . number_format($nakopit_item_energy, 3, ',', ' ') . ")</td>
                                        <td>
                                            <a data-toggle='collapse' href='#collapse_sub_" . $npp . "' aria-expanded='false' aria-controls='collapse_sub_" . $npp . "'>
                                                <i class='fa fa-info-circle' aria-hidden='true'></i>
                                            </a>
                                        </td>
                                    </tr>
                                    ";
                }

            }

            if ($row_prod_cnt == 0 && $row_semi_cnt == 0 && $row_pres_cnt == 0 && $row_reci_cnt == 0) {
                echo "<b style='color: orange;'>" . $row['component_name'] . "</b>";
                echo "<b style='color: orange;'> - а что это тогда? </b><br>";
                $collaps_block = $collaps_block . "
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
    
    if ($diagnostics_tab == 'on') {
        //     Диагностика данных о подсчёте пищевой ценности!
        echo '<br><b style="color: #ff7479;">Показатели блюда "'.$row[$tabname . '_name'] .'": </b><br>';

        echo '<b style="color: #ff7479;">цена: </b>' . number_format($nakopit_item_cost, 2, ',', ' ') . ' : ';
        echo '<b style="color: #ff7479;">брутто: </b>' . number_format($nakopit_item_gros, 3, ',', ' ') . ' : ';
        echo '<b style="color: #ff7479;">нетто: </b>' . number_format($nakopit_item_net, 3, ',', ' ') . ' : ';
        echo '<b style="color: #ff7479;">белок: </b>' . number_format($nakopit_item_protein, 3, ',', ' ') . ' : ';
        echo '<b style="color: #ff7479;">жир: </b>' . number_format($nakopit_item_fat, 3, ',', ' ') . ' : ';
        echo '<b style="color: #ff7479;">углев: </b>' . number_format($nakopit_item_carbohydrate, 3, ',', ' ') . ' : ';
        echo '<b style="color: #ff7479;">энерг: </b>' . number_format($nakopit_item_energy, 3, ',', ' ') . '<br>';
    }
}



if ($npp !== 0) {
    $item_net = $nakopit_item_net;
    $item_cost = $nakopit_item_cost;
    $item_protein = $nakopit_item_protein;
    $item_fat = $nakopit_item_fat;
    $item_carbohydrate = $nakopit_item_carbohydrate;
    $item_energy = $nakopit_item_energy;

    if ($nutr_val == '1') {
        $nutr = $item_net / 0.1;
    } else {
        $nutr = 1;
    }

    $item_protein = $item_protein / $nutr;
    $item_fat = $item_fat / $nutr;
    $item_carbohydrate = $item_carbohydrate / $nutr;
    $item_energy = $item_energy / $nutr;

    echo "
<tr>
    <td>" . $npp . "</td>
    <td>" . $item_name . "</td>
    <td class='td-right'>" . number_format($item_net, 3, ',', ' ') . "</td>
    <td class='td-right'>" . number_format($item_cost, 2, ',', ' ') . "</td>
    <td class='td-right'>" . number_format($item_protein, 3, ',', ' ') . "</td>
    <td class='td-right'>" . number_format($item_fat, 3, ',', ' ') . "</td>
    <td class='td-right'>" . number_format($item_carbohydrate, 3, ',', ' ') . "</td>
    <td class='td-right'>" . number_format($item_energy, 3, ',', ' ') . "</td>";
    if ($edbutt == '1') {
        echo "
    <td class='td-right'>
        <!-- Button trigger modal -->
        <a data-toggle='collapse' href='#collapse_" . $npp . "' aria-expanded='false' aria-controls='collapse_" . $npp . "'>
            <i class='fa fa-info-circle' aria-hidden='true'></i></a>

        &nbsp;&nbsp;

        <a name='del' href=" . $urlform . "?del=" . urlencode($item_name) . " onclick ='return confirm(\"Удалить {$item_name}?\")'>
            <i class='fa fa-trash-o' aria-hidden='true' style='color: red;'></i></a>

        &nbsp;&nbsp;

        <a name='edit' href=" . $urlform . "?editrow=editrow&edit_name=" . urlencode($item_name) . ">
            <i class='fa fa-pencil-square-o' aria-hidden='true' style='color: cornflowerblue;'></i></a>
    </td>
    ";
    }
    echo "
</tr>";

    $collaps_block = $collaps_block . "
                </tbody>
            </table>
        </div>
    </td>
</tr>
";

// Вывод блока, который разворачивается, когда нажимаешь на ссылку "i"
    echo $collaps_block;

    $nakopit_item_gros = 0;
    $nakopit_item_net = 0;
    $nakopit_item_cost = 0;
    $nakopit_item_protein = 0;
    $nakopit_item_fat = 0;
    $nakopit_item_carbohydrate = 0;
    $nakopit_item_energy = 0;
}
$mysqli->close();

?>