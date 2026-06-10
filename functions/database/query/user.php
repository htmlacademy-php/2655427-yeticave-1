<?php

declare(strict_types=1);

/**
 * Get user information by email
 *
 * @param mysqli $connection Active database connection
 * @param string $email
 *
 * @return array|null
 */
function getUserByEmail(mysqli $connection, string $email): ?array {
    $sql = "SELECT
        id,
        email,
        name,
        password_hash
    FROM `user`
    WHERE email = ?";

    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $user = mysqli_fetch_assoc($result);

    return $user ?? null;
}

/**
 * Adding user data to the database
 *
 * @param mysqli $connection Active database connection
 * @param array  $data
 *
 * @return string|int|null
 */
function addUser(mysqli $connection, array $data): string|int|null {
    $sql = "INSERT INTO user (
        email,
        name,
        password_hash,
        contact_info
    ) VALUES (?, ?, ?, ?)";

    $stmt = db_get_prepare_stmt($connection, $sql, $data);
    if (mysqli_stmt_execute($stmt)) {
        return mysqli_insert_id($connection);
    }
    return null;
}
