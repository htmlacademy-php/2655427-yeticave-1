<?php

declare(strict_types=1);

/**
 * connect to MySQL
 *
 * @return mysqli
 */
function connectToMySQL(): mysqli {
    $db = require 'config/db.php';

    $con = mysqli_connect(
        $db['host'],
        $db['user'],
        $db['password'],
        $db['database']
    );

    if (!$con) {
        exit('Ошибка подключения: ' . mysqli_connect_error());
    }

    mysqli_set_charset($con, 'utf8mb4');

    return $con;
}
