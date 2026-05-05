<?php

// Connect to MySQL
$db = require __DIR__ . '/db.php';

$con = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($con, "utf8mb4");

if (!$con) {
   print("Ошибка подключения: " . mysqli_connect_error());
}
