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

/**
 * Executes an SQL query and returns all result rows
 *
 * @param mysqli $con
 * @param string $sql_query
 * @return array
 */
function fetchAll(mysqli $con, string $sql_query): array {
    $result = mysqli_query($con, $sql_query);

    if (!$result) {
        error_log(mysqli_error($con));
        return [];
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Executes an SQL query and returns a single result row
 *
 * @param mysqli $con
 * @param string $sql_query
 * @return ?array
 */
function fetchOne(mysqli $con, string $sql_query): array|null {
    $result = mysqli_query($con, $sql_query);

    if (!$result) {
        error_log(mysqli_error($con));
        return null;
    }
    return mysqli_fetch_assoc($result);
}
