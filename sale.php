<?php

session_start();
if (!isset($_SESSION['login'])) {
    $_SESSION['page'] = $_SERVER['REQUEST_URI'];
    header("Location: http://bar-1.ru/_sushi/index.php?authorization");
    exit;
}

?>

<?php include 'modules/database.php'; ?>
<?php
//Session Start
session_start();

//Customer Add
$customer = $_POST['customer']; //Клиент
$first_name = $_POST['first_name']; //Имя клиента
$last_name = $_POST['last_name']; //Фамилия клиента
$middle_name = $_POST['middle_name']; //Отчество клиента
$birthday = $_POST['birthday']; //День рождения клиента
$source = $_POST['source']; //Откуда клиент узнал о нас
$referrer = $_POST['referrer']; //Кто "привёл" клиента
$phone_1 = $_POST['phone_1']; //Телефон и ID клиента 
$phone_2 = $_POST['phone_2']; //Допольнительный телефон клиента
$street = $_POST['street']; //Адрес клиента - улица
$house = $_POST['house']; //Адрес клиента - номер дома
$apartment = $_POST['apartment']; //Адрес клиента - номер квартиры
$entrance = $_POST['entrance']; //Адрес клиента - номер подъезда
$floor = $_POST['floor']; //Адрес клиента - номер этажа
$intercom = $_POST['intercom']; //Адрес клиента - код домофона
$link_vk = $_POST['link_vk']; //Ссылка на профиль в вк
$link_fb = $_POST['link_fb']; //Ссылка на профиль в фейсбук
$customer_comment = $_POST['customer_comment']; //Комментарий к профилю клиента

//Order Add
$dish

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Продажи</title>

    <?php include 'modules/_header.txt'; ?>

</head>
<body>
<br>
<!-- Контейнер с навигацией -->
<?php include 'modules/_navigation.txt'; ?>
<!-- /Контейнер с навигацией -->

<!-- Контейнер с заголовком страницы и "местоной" навигацией -->
<div class="container">
    <div class="row">
        <br>
        <h1 class="display-1">Продажи</h1>
        <br>
        <div>
            <a href="product.php" class="btn btn-info">Продажа</a>
            <a href="product_purchase.php" class="btn btn-outline-success">Аналитика</a>
            <a href="product_salvage.php" class="btn btn-outline-danger">Редактор</a>
        </div>
    </div>
</div>
<!-- /Контейнер с заголовком страницы и "местоной" навигацией -->
<br>
<!-- Контейнер с формой новой продажи! -->
<div class="container">
    <div class="row">
        <h2>Новая продажа!</h2>
        <div class='addform'>
            <div class='container'>

                <form action='sale.php' class='form-horizontal' method='post'>
                    <div class='row'>
                        <div class='col-xs-1'>
                            <p class='form-control-static'>Клиент:</p>
                        </div>
                        <div class='col-xs-3'>
                            <div class='form-group'>
                                <input class='col-xs-4 form-control' type="text" name="customer" id="customer" list="customers" placeholder="Клиент" required>
                                <datalist id="customers">
                                    <select class='form-control' name='customer'>
                                        <option value=''>Выберите клиента</option>
                                        <option value='79611000880'>79611000880 (Роман)</option>
                                        <option value='79103318388'>79103318388 (Анна)</option>
                                    </select>
                                </datalist>
                            </div>
                        </div>
                        <div class='col-xs-1'>
                            <button type='submit' class='btn btn-outline-success'>Ok!</button>
                        </div>
                        <div class='col-xs-7'>
                            <p class='form-control-static text-xs-center'><strong>Клиент с 10.10.2016 г.</strong>&nbsp;<strong style='color: red'>(3 заказа)</strong>
                            <a class="btn btn-link" data-toggle="collapse" href="#collapseCustomer" aria-expanded="false" aria-controls="collapseCustomer">
                                Подробнее
                            </a>
                            </p>
                        </div>
                    </div>
                </form>


                <form action='sale.php' class='form-horizontal' method='post'>
                    <div class='row collapse'  id='collapseCustomer' style="color: #69b1e5">
                        <div class='col-xs-12'>
                            <div class='row'>
                                <div class='col-xs-12'>
                                    <hr>
                                    <h4>Информация о клиенте</h4>
                                    <br>
                                </div>
                            </div>
                            <div class='row'>
                                <!-- Фамилия -->
                                <div class='col-xs-1'>
                                    <p class='form-control-static'>Фамилия:</p>
                                </div>
                                <div class='col-xs-4'>
                                    <div class='form-group'>
                                        <input type='text' class='form-control ' name='last_name' placeholder='Фамилия'>
                                    </div>
                                </div>
                                <!-- /Фамилия -->

                                <!-- Имя -->
                                <div class='col-xs-1'>
                                    <p class='form-control-static'>Имя:</p>
                                </div>
                                <div class='col-xs-2'>
                                    <div class='form-group'>
                                        <input type='text' class='form-control' name='first_name' placeholder='Имя'>
                                    </div>
                                </div>
                                <!-- /Имя -->

                                <div class='col-xs-1'>
                                    <p class='form-control-static'>Отчество:</p>
                                </div>
                                <div class='col-xs-3'>
                                    <div class='form-group'>
                                        <input type='text' class='form-control' name='middle_name' placeholder='Отчество'>
                                    </div>
                                </div>
                                <!-- /Отчество -->
                            </div>
                            <div class='row'>
                                <!-- Дата рождения -->
                                <div class='col-xs-2'>
                                    <p class='form-control-static'>Дата рождения:</p>
                                </div>
                                <div class='col-xs-3'>
                                    <div class='form-group'>
                                        <div class='input-group'>
                                            <input type='date' class='form-control' id='birthday' name='birthday'>
                                            <span class='input-group-addon'><i class='fa fa-calendar' aria-hidden='true'></i></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Дата рождения -->

                                <!-- Источник -->
                                <div class='col-xs-1'>
                                    <p class='form-control-static'>Источник:</p>
                                </div>
                                <div class='col-xs-2'>
                                    <div class='form-group'>
                                        <select class='form-control' name='source'>
                                            <option value=''>Укажите источник</option>
                                            <optgroup label='Источники'>
                                                <option>Друзья</option>
                                                <option>Интернет</option>
                                                <option>Полиграфия</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <!-- /Источник -->

                                <!-- Реферер -->
                                <div class='col-xs-1'>
                                    <p class='form-control-static'>Реферер:</p>
                                </div>
                                <div class='col-xs-3'>
                                    <div class='form-group'>
                                        <input class='form-control' type="text" name="referrer" list="referrers" placeholder="Реферер">
                                        <datalist id="referrers">
                                            <select class='form-control' name='referrer'>
                                                <option value=''>Выберите клиента</option>
                                                <option value='79611000880'>79611000880 (Роман)</option>
                                                <option value='79103318388'>79103318388 (Анна)</option>
                                            </select>
                                        </datalist>
                                    </div>
                                </div>
                                <!-- /Реферер -->
                            </div>
                            <div class='row'>
                                <!-- Телефон клиента 1 и id-клиента -->
                                <div class='col-xs-3'>
                                    <p class='form-control-static'>Телефон клиента (id):</p>
                                </div>
                                <div class='col-xs-3'>
                                    <div class='form-group'>
                                        <input class='form-control' type='text' placeholder='Телефон и id клиента' name='phone_1' required>
                                    </div>
                                </div>
                                <!-- /Телефон клиента 1 и id-клиента -->

                                <!-- Дополнительный телефон -->
                                <div class='col-xs-3'>
                                    <p class='form-control-static'>Дополнительный телефон:</p>
                                </div>
                                <div class='col-xs-3'>
                                    <div class='form-group'>
                                        <input class='form-control' type='text' placeholder='Дополнительный телефон' name='phone_2'>
                                    </div>
                                </div>
                                <!-- /Дополнительный телефон -->

                            </div>
                            <div class='row'>
                                <!-- Улица -->
                                <div class='col-xs-1'>
                                    <p class='form-control-static'>Улица:</p>
                                </div>
                                <div class='col-xs-4'>
                                    <div class='form-group'>
                                        <input class='form-control' type='text' placeholder='Улица' name='street' required>
                                    </div>
                                </div>
                                <!-- /Улица -->

                                <!-- Номер дома -->
                                <div class='col-xs-1'>
                                    <p class='form-control-static'>Дом:</p>
                                </div>
                                <div class='col-xs-2'>
                                    <div class='form-group'>
                                        <input class='form-control' type='text' placeholder='Дом' name='house' required>
                                    </div>
                                </div>
                                <!-- /Номер дома -->

                                <!-- Квартира -->
                                <div class='col-xs-1'>
                                    <p class='form-control-static'>Квартира:</p>
                                </div>
                                <div class='col-xs-2'>
                                    <div class='form-group'>
                                        <input class='form-control' type='text' placeholder='Квартира' name='apartment' required>
                                    </div>
                                </div>
                                <!-- /Квартира -->

                            </div>
                            <div class='row'>
                                <!-- Подъезд -->
                                <div class='col-xs-1'>
                                    <p class='form-control-static'>Подъезд:</p>
                                </div>
                                <div class='col-xs-2'>
                                    <div class='form-group'>
                                        <input class='form-control' type='text' placeholder='Подъезд' name='entrance'>
                                    </div>
                                </div>
                                <!-- /Подъезд -->

                                <!-- Этаж -->
                                <div class='col-xs-1'>
                                    <p class='form-control-static'>Этаж:</p>
                                </div>
                                <div class='col-xs-2'>
                                    <div class='form-group'>
                                        <input class='form-control' type='text' placeholder='Этаж' name='floor'>
                                    </div>
                                </div>
                                <!-- /Этаж -->

                                <!-- Код домофона -->
                                <div class='col-xs-1'>
                                    <p class='form-control-static'>Домофон:</p>
                                </div>
                                <div class='col-xs-2'>
                                    <div class='form-group'>
                                        <input class='form-control' type='text' placeholder='Код домофона' name='intercom'>
                                    </div>
                                </div>
                                <!-- /Код домофона -->

                            </div>
                            <div class='row'>
                                <!-- Ссылка VK -->
                                <div class='col-xs-2'>
                                    <p class='form-control-static'>Профиль VK:</p>
                                </div>
                                <div class='col-xs-4'>
                                    <div class='form-group'>
                                        <input class='form-control' type='text' placeholder='Ссылка на профиль VK' name='link_vk'>
                                    </div>
                                </div>
                                <!-- /Ссылка VK -->

                                <!-- Ссылка FB -->
                                <div class='col-xs-2'>
                                    <p class='form-control-static'>Профиль FB:</p>
                                </div>
                                <div class='col-xs-4'>
                                    <div class='form-group'>
                                        <input class='form-control' type='text' placeholder='Ссылка на профиль FB' name='link_fb'>
                                    </div>
                                </div>
                                <!-- /Ссылка FB -->

                            </div>
                            <div class='row'>
                                <!-- Комментарий -->
                                <div class='col-xs-2'>
                                    <p class='form-control-static'>Комментарий:</p>
                                </div>
                                <div class='col-xs-10'>
                                    <div class='form-group'>
                                        <input class='form-control' type='text' placeholder='Комментарий' name='customer_comment'>
                                    </div>
                                </div>
                                <!-- /Комментарий -->
                            </div>
                            <div class='row'>
                                <div class='col-xs-12'>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="add_field_area">
                        <!-- Блюдо 1 -->
                        <div id='add$i' class='add row'>
                            <!-- Блюдо -->
                            <div class='col-xs-4'>
                                <div class='form-group'>
                                    <input class='col-xs-4 form-control' type="text" name="dish-1" id="dish-1" list="dishs" placeholder="Блюдо" required>
                                    <datalist id="dishs">
                                        <select class='form-control' name='dish-1'>
                                            <option value=''>Выберите блюдо</option>
                                            <option value='Аканэ'>Аканэ</option>
                                            <option value='Амстердам'>Амстердам</option>
                                        </select>
                                    </datalist>
                                </div>
                            </div>
                            <!-- /Блюдо -->

                            <!-- Количество в заказе -->
                            <div class='col-xs-2'>
                                <div class='form-group'>
                                    <div class='input-group'>
                                        <input type='number' min='1' max='10' step='1' placeholder='Количество' class='form-control' name='amount_3' required>
                                        <span class='input-group-addon'><i class='fa fa-shopping-bag' aria-hidden='true'></i></span>
                                    </div>
                                </div>
                            </div>
                            <!-- /Количество в заказе -->

                            <!-- Скидка -->
                            <div class='col-xs-2'>
                                <div class='form-group'>
                                    <select class='form-control' name='discount-1'>
                                        <option value=''>Выберите скидку</option>
                                        <optgroup label='Скидки'>
                                            <option>Подарок в день рождения (100%)</option>
                                            <option>Ещё какая-то скидка</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <!-- /Скидка -->


                            <!-- Комментарий к компоненту -->
                            <div class='col-xs-3'>
                                <div class='form-group'>
                                    <input type='text' placeholder='Комментарий' class='col-xs-4 form-control' id='comment_{$i}' name='comment_{$i}'>
                                </div>
                            </div>


                            <!-- Управляющие конструкции -->
                            <div class='col-xs-1'>
                                <p class='form-control-static'>
                                    <i class='fa fa-trash-o' aria-hidden='true' style='color: red; cursor: pointer' onclick='deleteField({$i});'></i>
                                </p>
                            </div>
                        </div>
                        <!-- /Блюдо 1 -->
                        <!-- Блюдо 2 -->
                        <div id='add$i' class='add row'>
                            <!-- Блюдо -->
                            <div class='col-xs-4'>
                                <div class='form-group'>
                                    <input class='col-xs-4 form-control' type="text" name="dish-1" id="dish-1" list="dishs" placeholder="Блюдо" required>
                                    <datalist id="dishs">
                                        <select class='form-control' name='dish-1'>
                                            <option value=''>Выберите блюдо</option>
                                            <option value='Аканэ'>Аканэ</option>
                                            <option value='Амстердам'>Амстердам</option>
                                        </select>
                                    </datalist>
                                </div>
                            </div>
                            <!-- /Блюдо -->

                            <!-- Количество в заказе -->
                            <div class='col-xs-2'>
                                <div class='form-group'>
                                    <div class='input-group'>
                                        <input type='number' min='1' max='10' step='1' placeholder='Количество' class='form-control' name='amount_3' required>
                                        <span class='input-group-addon'><i class='fa fa-shopping-bag' aria-hidden='true'></i></span>
                                    </div>
                                </div>
                            </div>
                            <!-- /Количество в заказе -->

                            <!-- Скидка -->
                            <div class='col-xs-2'>
                                <div class='form-group'>
                                    <select class='form-control' name='discount-1'>
                                        <option value=''>Выберите скидку</option>
                                        <optgroup label='Скидки'>
                                            <option>Подарок в день рождения (100%)</option>
                                            <option>Ещё какая-то скидка</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <!-- /Скидка -->


                            <!-- Комментарий к компоненту -->
                            <div class='col-xs-3'>
                                <div class='form-group'>
                                    <input type='text' placeholder='Комментарий' class='col-xs-4 form-control' id='comment_{$i}' name='comment_{$i}'>
                                </div>
                            </div>


                            <!-- Управляющие конструкции -->
                            <div class='col-xs-1'>
                                <p class='form-control-static'>
                                    <i class='fa fa-trash-o' aria-hidden='true' style='color: red; cursor: pointer' onclick='deleteField({$i});'></i>
                                </p>
                            </div>
                        </div>
                        <!-- /Блюдо 2 -->
                        <!-- Блюдо 3 -->
                        <div id='add$i' class='add row'>
                            <!-- Блюдо -->
                            <div class='col-xs-4'>
                                <div class='form-group'>
                                    <input class='col-xs-4 form-control' type="text" name="dish-1" id="dish-1" list="dishs" placeholder="Блюдо" required>
                                    <datalist id="dishs">
                                        <select class='form-control' name='dish-1'>
                                            <option value=''>Выберите блюдо</option>
                                            <option value='Аканэ'>Аканэ</option>
                                            <option value='Амстердам'>Амстердам</option>
                                        </select>
                                    </datalist>
                                </div>
                            </div>
                            <!-- /Блюдо -->

                            <!-- Количество в заказе -->
                            <div class='col-xs-2'>
                                <div class='form-group'>
                                    <div class='input-group'>
                                        <input type='number' min='1' max='10' step='1' placeholder='Количество' class='form-control' name='amount_3' required>
                                        <span class='input-group-addon'><i class='fa fa-shopping-bag' aria-hidden='true'></i></span>
                                    </div>
                                </div>
                            </div>
                            <!-- /Количество в заказе -->

                            <!-- Скидка -->
                            <div class='col-xs-2'>
                                <div class='form-group'>
                                    <select class='form-control' name='discount-1'>
                                        <option value=''>Выберите скидку</option>
                                        <optgroup label='Скидки'>
                                            <option>Подарок в день рождения (100%)</option>
                                            <option>Ещё какая-то скидка</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <!-- /Скидка -->


                            <!-- Комментарий к компоненту -->
                            <div class='col-xs-3'>
                                <div class='form-group'>
                                    <input type='text' placeholder='Комментарий' class='col-xs-4 form-control' id='comment_{$i}' name='comment_{$i}'>
                                </div>
                            </div>


                            <!-- Управляющие конструкции -->
                            <div class='col-xs-1'>
                                <p class='form-control-static'>
                                    <i class='fa fa-trash-o' aria-hidden='true' style='color: red; cursor: pointer' onclick='deleteField({$i});'></i>
                                </p>
                            </div>
                        </div>
                        <!-- /Блюдо 3 -->
                    </div>

                    <div class='row'>
                        <div class='col-xs-12'>
                            <i class='fa fa-plus pull-right' aria-hidden='true' style='color: green; cursor: pointer' onclick='addField();'></i>
                        </div>
                    </div>

                    <div class='row'>
                        <!-- Выбор времени доставки -->
                        <div class='col-xs-12'>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="exampleRadios" value="now" checked>
                                    Оперативная доставка (дату и время ниже можно не указывать)
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="exampleRadios" value="preorder">
                                    Предварительная заявка (ОБЯЗАТЕЛЬНО указать дату и время ниже)
                                    <a data-toggle="collapse" href="#collapsePreOrder" aria-expanded="false" aria-controls="collapsePreOrder">
                                    открыть
                                    </a>
                                </label>
                            </div>
                        </div>
                        <!-- /Выбор времени доставки -->
                    </div>
                    <div class='row collapse'  id='collapsePreOrder' style="color: #6374e5">
                        <!-- Предварительная заявка -->
                        <div class='col-xs-1'>
                            <p class='form-control-static'>Доставить:</p>
                        </div>

                        <div class='col-xs-3'>
                            <div class='form-group'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' name='delivery_time'>
                                    <span class='input-group-addon'><i class='fa fa-calendar' aria-hidden='true'></i></span>
                                </div>
                            </div>
                        </div>

                        <div class='col-xs-2'>
                            <p class='form-control-static'>Время доставки:</p>
                        </div>

                        <div class='col-xs-2'>
                            <div class='form-group'>
                                <div class='input-group'>
                                    <input type='time' class='form-control' name='delivery_time'>
                                    <span class='input-group-addon'><i class='fa fa-clock-o' aria-hidden='true'></i></span>
                                </div>
                            </div>
                        </div>
                        <!-- /Предварительная заявка -->
                    </div>
                    <div class='row'>
                        <!-- Скидка на весь заказ -->
                        <div class='col-xs-2'>
                            <p class='form-control-static'>Скидка на заказ:</p>
                        </div>
                        <div class='col-xs-2'>
                            <div class='form-group'>
                                <select class='form-control' name='dish_discount'>
                                    <option value=''>Выберите скидку</option>
                                    <optgroup label='Скидки'>
                                        <option>Подарок в день рождения (100%)</option>
                                        <option>Ещё какая-то скидка</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <!-- /Скидка на весь заказ -->

                        <!-- Купюра к оптате -->
                        <div class='col-xs-1'>
                            <p class='form-control-static'>Сдача&nbsp;с:</p>
                        </div>
                        <div class='col-xs-2'>
                            <div class='form-group'>
                                <div class='input-group'>
                                    <input type='number' min='1' max='5000' step='1' placeholder='Купюра' class='form-control' name='banknote'>
                                    <span class='input-group-addon'><i class='fa fa-rub' aria-hidden='true'></i></span>
                                </div>
                            </div>
                        </div>
                        <!-- /Купюра к оптате -->

                        <!-- Палочек -->
                        <div class='col-xs-2'>
                            <p class='form-control-static'>Пар палочек:</p>
                        </div>
                        <div class='col-xs-2'>
                            <div class='form-group'>
                                <select class='form-control' name='kit'>
                                    <option>0</option>
                                    <option>1</option>
                                    <option selected>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                </select>
                            </div>
                        </div>
                        <!-- /Палочек -->

                    </div>
                    <div class="row">
                        <!-- Источник заказа -->
                        <div class='col-xs-2'>
                            <p class='form-control-static'>Источник заказа:</p>
                        </div>
                        <div class='col-xs-2'>
                            <div class='form-group'>
                                <select class='form-control' name='source_order'>
                                    <option value=''>Выберите источник</option>
                                    <optgroup label='Источники заказа'>
                                        <option>По телефону</option>
                                        <option>В баре</option>
                                        <option>С сайта</option>
                                        <option>Через Заку</option>
                                        <option>Через Деливери</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <!-- /Источник заказа -->

                        <!-- Комментарий к компоненту -->
                        <div class='col-xs-3'>
                            <p class='form-control-static'>Комментарий к заказу:</p>
                        </div>
                        <div class='col-xs-5'>
                            <div class='form-group'>
                                <input type='text' placeholder='Комментарий' class='form-control' name='order_comment'>
                            </div>
                        </div>
                        <!-- /Комментарий к компоненту -->
                    </div>
                    <!-- КНОПКИ -->
                    <div class='form-group row'>
                        <div class='col-xs-12'>
                            <!-- Клиент -->
                            <input type='hidden' name='customer' value='customer_id'>
                            <!-- /Клиент -->
                            <button type='submit' name='addnewitem' class='btn btn-outline-success pull-right'>Посчитать заказ!</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Контейнер с формой новой продажи! -->
<br>
<!-- Контейнер с таблицей продаж за текущий день -->
<div class="container">
    <div class="row">
        <h4>19.10.2016 г.</h4>

        <table class='table table-hover' id='check_tab'>
            <thead>
                <tr>
                    <th>№ п/п</th>
                    <th>Время заказа</th>
                    <th>№ чека</th>
                    <th>Клиент</th>
                    <th class='td-right'>Сумма чека</th>
                    <th class='td-right'>Редакт.</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>10:50</td>
                <td>1</td>
                <td>79611000880 (Роман)</td>
                <td class='td-right'>750 р.</td>
                <td class='td-right'>
                    <!-- Button trigger modal -->
<!--                    <a data-toggle='collapse' href='#collapse_" . $npp . "' aria-expanded='false' aria-controls='collapse_" . $npp . "'>-->
                    <a data-toggle='collapse' href='#collapse_1' aria-expanded='false' aria-controls='collapse_1'>
                        <i class='fa fa-info-circle' aria-hidden='true'></i></a>

                    &nbsp;&nbsp;

                    <a name='del' href=" . $urlform . "?del=" . urlencode($item_name) . " onclick ='return confirm(\"Удалить {$item_name}?\")'>
                        <i class='fa fa-trash-o' aria-hidden='true' style='color: red;'></i></a>

                    &nbsp;&nbsp;

                    <a name='edit' href=" . $urlform . "?editrow=editrow&edit_name=" . urlencode($item_name) . ">
                    <i class='fa fa-pencil-square-o' aria-hidden='true' style='color: cornflowerblue;'></i></a>
                </td>
            </tr>
            <tr class='infoblock'>
                <td colspan='6'>
                    <div class='collapse' id='collapse_1'>
                        <h5>Состав заказа</h5>
                        <table class='table table-sm'>
                            <thead>
                            <tr>
                                <th>№ п/п</th>
                                <th>Блюдо</th>
                                <th>Цена</th>
                                <th>Количество</th>
                                <th>Стоимость</th>
                                <th>Себестоимость</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Аканэ</td>
                                <td>225</td>
                                <td>2</td>
                                <td>450</td>
                                <td>150</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Амстердам</td>
                                <td>300</td>
                                <td>1</td>
                                <td>300</td>
                                <td>100</td>
                            </tr>
                            <tr>
                                <th colspan='4' class='td-right'>Итого:</th>
                                <th>750</th>
                                <th>250</th>
                            </tr>
                            </tbody>
                        </table>
                        <h5>Адрес доставки</h5>
                        <table class='table table-sm'>
                            <thead>
                            <tr>
                                <th>Улица</th>
                                <th>Дом</th>
                                <th>Квартира</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Крахмалёва</td>
                                <td>70</td>
                                <td>11</td>
                            </tr>
                            </tbody>
                        </table>
                        <h5>Исполнение заявки</h5>
                        <table class='table table-sm'>
                            <thead>
                            <tr>
                                <th>Псотупил</th>
                                <th>Принят поваром</th>
                                <th>Исполенен поваром</th>
                                <th>Принят курьером</th>
                                <th>Исполенен курьером</th>
                                <th>Всего затрачено</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>10:50</td>
                                <td>10:55</td>
                                <td>11:20</td>
                                <td>11:20</td>
                                <td>12:00</td>
                                <td><strong>1:10</strong></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>

            <tr>
                <th colspan='4' class='td-right'>Итого:</th>
                <th class='td-right'>750 р.</th>
                <th></th>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- /Контейнер с таблицей продаж за текущий день -->
<br>
<!-- Контейнер с таблицей продаж за текущий день -->
<div class="container">
    <div class="row">
        <form action='".$urlform."' method='post' class='form-inline'>
            <input type='password' placeholder='Пароль для редактирования' class='form-control' id='passforedit' name='passforedit' size='20'>
            <label for='num_rows'>Строк для добавления: </label>
            <input type='number' value='3' class='form-control' id='num_rows' name='num_rows' min='1' max='20' size='5'>

            <input type='hidden' name='showtype' value='show_manag'>
            <button type='submit' class='btn btn-outline-success'>Управлять данными</button>
        </form>
    </div>
</div>

<br>
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