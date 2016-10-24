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
            <i class='fa fa-times' aria-hidden='true' style='color: red;'></i></a>

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
                </tr>
                ";
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

                // Если единици измерения штуки (unit_id = 3) или порции (unit_id = 4) не учитываем вес этого элемента
                if ($product["unit_id"] == '3' || $product["unit_id"] == '4') {

                } else {
                $s_item_amount = $s_item_amount + $semi_row["component_net"];
                }
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

                $collaps_block = $collaps_block."
                <tr class='semi'>
                    <td>".$row['component_name']."</td>
                    <td class='td-right'>".number_format(($s_item_cost / $s_item_amount), 2, ',', ' ')."</td>
                    <td class='td-right'>".number_format($row["component_gross"], 3, ',', ' ')."</td>
                    <td class='td-right'>".number_format($row["component_net"], 3, ',', ' ')."</td>
                    <td class='nakopit'>(".number_format($nakopit_item_amount, 3, ',', ' ').")</td>
                    <td class='td-right'>".number_format($semi_item_cost, 2, ',', ' ')."</td>
                    <td class='nakopit'>(".number_format($nakopit_item_cost, 2, ',', ' ').")</td>
                    <td class='td-right'>".number_format($semi_item_protein, 3, ',', ' ')."</td>
                    <td class='nakopit'>(".number_format($nakopit_item_protein, 3, ',', ' ').")</td>
                    <td class='td-right'>".number_format($semi_item_fat, 3, ',', ' ')."</td>
                    <td class='nakopit'>(".number_format($nakopit_item_fat, 3, ',', ' ').")</td>
                    <td class='td-right'>".number_format($semi_item_carbohydrate, 3, ',', ' ')."</td>
                    <td class='nakopit'>(".number_format($nakopit_item_carbohydrate, 3, ',', ' ').")</td>
                    <td class='td-right'>".number_format($semi_item_energy, 3, ',', ' ')."</td>
                    <td class='nakopit'>(".number_format($nakopit_item_energy, 3, ',', ' ').")</td>
                </tr>
                ";

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

                // Если единици измерения штуки (unit_id = 3) или порции (unit_id = 4) не учитываем вес этого элемента
                if ($product["unit_id"] == '3' || $product["unit_id"] == '4') {

                } else {
                $prod_item_amount = $prod_item_amount + $row["component_net"];
                }
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

                // Если единици измерения штуки (unit_id = 3) или порции (unit_id = 4) не учитываем вес этого элемента
                if ($product["unit_id"] == '3' || $product["unit_id"] == '4') {

                } else {
                $nakopit_item_amount = $nakopit_item_amount + $row["component_net"];
                }
                $nakopit_item_cost = $nakopit_item_cost + $row["component_gross"] * $product["price_online"];
                $nakopit_item_protein = $nakopit_item_protein + $row["component_net"] * $product["protein"] / 0.1;
                $nakopit_item_fat = $nakopit_item_fat + $row["component_net"] * $product["fat"] / 0.1;
                $nakopit_item_carbohydrate = $nakopit_item_carbohydrate + $row["component_net"] * $product["carbohydrate"] / 0.1;
                $nakopit_item_energy = $nakopit_item_energy + $row["component_net"] * $product["energy"] / 0.1;


                $collaps_block = $collaps_block."
                <tr>
                    <td>".$row['component_name']."</td>
                    <td class='td-right'>".number_format($product["price_online"], 2, ',', ' ')."</td>
                    <td class='td-right'>".number_format($row["component_gross"], 3, ',', ' ')."</td>
                    <td class='td-right'>".number_format($row["component_net"], 3, ',', ' ')."</td>
                    <td class='nakopit'>(".number_format($nakopit_item_amount, 3, ',', ' ').")</td>

                    <td class='td-right'>".number_format(($row["component_gross"] * $product["price_online"]), 2, ',', ' ') ."</td>
                    <td class='nakopit'>(".number_format($nakopit_item_cost, 2, ',', ' ').")</td>

                    <td class='td-right'>".number_format((($row["component_net"] * $product["protein"]) / 0.1), 3, ',', ' ') . "</td>
                    <td class='nakopit'>(".number_format($nakopit_item_protein, 3, ',', ' ').")</td>

                    <td class='td-right'>".number_format((($row["component_net"] * $product["fat"]) / 0.1), 3, ',', ' ') ."</td>
                    <td class='nakopit'>(".number_format($nakopit_item_fat, 3, ',', ' ').")</td>

                    <td class='td-right'>".number_format((($row["component_net"] * $product["carbohydrate"]) / 0.1), 3, ',', ' ') ."</td>
                    <td class='nakopit'>(".number_format($nakopit_item_carbohydrate, 3, ',', ' ').")</td>

                    <td class='td-right'>".number_format((($row["component_net"] * $product["energy"]) / 0.1), 3, ',', ' ') ."</td>
                    <td class='nakopit'>(".number_format($nakopit_item_energy, 3, ',', ' ').")</td>
                </tr>
                ";
                }



                }
                }

                }
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
                            <i class='fa fa-times' aria-hidden='true' style='color: red;'></i></a>

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