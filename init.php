<?php

declare(strict_types=1);

require_once 'util/constant.php';
require_once 'functions/functions_db.php';
require_once 'functions/functions.php';
require_once 'functions/helpers.php';

// Connect to MySQL
$db = require_once 'config/db.php';

$con = mysqli_connect(
    $db['host'],
    $db['user'],
    $db['password'],
    $db['database']
);

mysqli_set_charset($con, "utf8mb4");

if (!$con) {
   print("Ошибка подключения: " . mysqli_connect_error());
}

$categories = getAllCategories($con);
$lots = getNewLots($con);
