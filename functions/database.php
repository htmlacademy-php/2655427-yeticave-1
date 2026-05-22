<?php

declare(strict_types=1);

/**
 * Get the newest open lots
 *
 * @param mysqli $connection
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
        lot.img_url,
        category.name AS category_name,
        lot.expire_date
    FROM `lot`
    LEFT JOIN `bid` ON bid.lot_id = lot.id
    JOIN `category` ON category.id = lot.category_id
    WHERE lot.id = $id
    GROUP BY lot.id";

    return fetchOne($connection, $sql);
}

/**
 * Get all lots by category
 *
 * @param mysqli $connection
 * @param ?string $category_slug
 * @return array
 */
function getLotsByCategory(mysqli $connection, ?string $category_slug): array {
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
 * Adding lot data from the form to the database
 *
 * @param mysqli $connection
 * @param array $data
 * @return bool
 */
function addLot(mysqli $connection, array $data): bool {
    $sql = "INSERT INTO lot (
        title,
        description,
        start_price,
        expire_date,
        bid_step,
        category_id,
        img_url,
        author_id
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)";

    $stmt = db_get_prepare_stmt($connection, $sql, $data);
    return mysqli_stmt_execute($stmt);
}
