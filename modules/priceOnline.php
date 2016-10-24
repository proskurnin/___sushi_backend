<?php


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


?>