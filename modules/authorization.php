<?php

session_start();
include 'database.php';

if (isset($_POST['enter'])) {
    $login = $_POST['login'];
    $password = md5($_POST['password']);
    $query = "SELECT * FROM `users` WHERE login='$login'";
    $selection = $mysqli->query($query) or die($query);
    $user_data = $selection->fetch_assoc();

    if ($user_data['password'] == $password) {
        $_SESSION['login'] = $login;
        if (isset($_SESSION['page'])) header("Location: $_SESSION[page]"); else header("Location: ../sale.php");
        exit;
    } else {
        $_SESSION['error'] = "Вы указали не верные данные!";
        header("Location: ../index.php?error");
        exit;
    };
};

if (isset($_POST['logout'])) {
    unset($_SESSION['login']);
    unset($_SESSION['page']);
    session_destroy();
    header("Location: ../index.php");
    exit;
};

?>