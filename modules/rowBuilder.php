<?php



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

?>