<?php

declare(strict_types=1);

/**
 * Get the newest open lots
 *
 * @param mysqli $connection
 *
 * @return array
 */
function getNewLots(mysqli $connection): array {
    $sql = "SELECT
        lot.id AS lot_id,
        lot.title,
        lot.start_price,
        lot.img_url,
        category.name AS category_name,
        lot.expire_date
    FROM `lot`
    LEFT JOIN `bid` ON bid.lot_id = lot.id
    JOIN `category` ON category.id = lot.category_id
    WHERE lot.expire_date > NOW()
    ORDER BY lot.created_at DESC
    LIMIT 6";

    return fetchAll($connection, $sql);
}

/**
 * Get all categories
 *
 * @param mysqli $connection
 *
 * @return array
 */
function getAllCategories(mysqli $connection): array {
    $sql = "SELECT `id`, `name`, `slug` FROM category";

    return fetchAll($connection, $sql);
}

/**
 * Get information about a lot by id
 *
 * @param mysqli $connection
 * @param int $id
 *
 * @return ?array
 */
function getLotById(mysqli $connection, int $id): ?array {
    if ($id === 0) {
        return null;
    }

    $sql = "SELECT
        lot.id AS lot_id,
        lot.title,
        lot.description,
        lot.start_price,
        COALESCE(MAX(bid.amount), lot.start_price) AS current_price,
        lot.bid_step,
        lot.img_url,
        category.name AS category_name,
        lot.expire_date,
        lot.author_id
    FROM `lot`
    LEFT JOIN `bid` ON bid.lot_id = lot.id
    JOIN `category` ON category.id = lot.category_id
    WHERE lot.id = $id
    GROUP BY lot.id";

    return fetchOne($connection, $sql);
}

/**
 * Get the betting history
 *
 * @param mysqli $connection
 * @param int $id
 *
 * @return ?array
 */
function getBidsByLotId(mysqli $connection, int $id): ?array {
    if ($id === 0) {
        return [];
    }

    $sql ="SELECT
        user.name AS user_name,
        bid.amount,
        bid.created_at,
        bid.user_id
    FROM `bid`
    JOIN `user` ON  bid.user_id = user.id
    WHERE bid.lot_id = $id
    ORDER BY bid.created_at DESC";

    return fetchAll($connection, $sql);
}

/**
 * Get all lots by category
 *
 * @param mysqli $connection
 * @param string|null $category_slug
 *
 * @return array
 */
function getLotsByCategorySlug(mysqli $connection, ?string $category_slug): array {
    $category_slug = mysqli_real_escape_string($connection, $category_slug);

    $sql = "SELECT
        lot.id AS lot_id,
        lot.title,
        lot.start_price,
        lot.img_url,
        category.name AS category_name,
        lot.expire_date
    FROM `lot`
    JOIN `category` ON category.id = lot.category_id
    WHERE lot.expire_date > NOW() AND category.slug = '$category_slug'
    ORDER BY lot.created_at DESC
    LIMIT 6";

    return fetchAll($connection, $sql);
}

/**
 * Get the category name
 *
 * @param mysqli $connection
 * @param string|null $category_slug
 *
 * @return array
 */
function getCategoryName(mysqli $connection, ?string $category_slug): array {
    $category_slug = mysqli_real_escape_string($connection, $category_slug);

    $sql = "SELECT
        name
    FROM `category`
    WHERE slug = '$category_slug'";

    return fetchOne($connection, $sql);
}

/**
 * Adding lot data from the form to the database
 *
 * @param mysqli $connection
 * @param array $data
 *
 * @return string|int|null
 */
function addLot(mysqli $connection, array $data): string|int|null {
    $sql = "INSERT INTO lot (
        title,
        description,
        start_price,
        expire_date,
        bid_step,
        category_id,
        img_url,
        author_id
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = db_get_prepare_stmt($connection, $sql, $data);
    if (mysqli_stmt_execute($stmt)) {
        return mysqli_insert_id($connection);
    }
    return null;
}

/**
 * Get user information by email
 *
 * @param mysqli $connection
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
 * @param mysqli $connection
 * @param array $data
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

/**
 * Gets lots by search query using full-text search
 *
 * @param mysqli $connection
 * @param string $value Search query string
 *
 * @return array List of found lots
 */
function getAllLotsBySearch(mysqli $connection, string $value): array {
    $sql = "SELECT
        lot.id AS lot_id,
        lot.title,
        lot.start_price,
        lot.img_url,
        category.name AS category_name,
        lot.expire_date
    FROM `lot`
    JOIN `category` ON category.id = lot.category_id
    WHERE MATCH(lot.title,lot.description) AGAINST(?)
    ORDER BY lot.created_at DESC
    LIMIT 9";

    $stmt = db_get_prepare_stmt($connection, $sql, [$value]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
