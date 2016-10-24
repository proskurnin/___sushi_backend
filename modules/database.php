<?php
//Create connections credentials
$db_host = 'localhost';
$db_name = 'u0216880_sushi';
$db_user = 'u0216880_sushi';
$db_pass = '02oL1NdiCm';

//Create mysqli object
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

//Error Handler
if($mysqli->connect_error) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

?>