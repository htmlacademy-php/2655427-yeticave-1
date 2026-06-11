<?php

declare(strict_types=1);

/**
 * Get the newest open lots
 *
 * @param mysqli $connection Active database connection
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
 * Get information about a lot by id
 *
 * @param mysqli $connection Active database connection
 * @param int    $id
 *
 * @return ?array
 */
function getLotById(mysqli $connection, int $id): ?array {
    if ($id === 0) {
        return null;
    }

    $sql = "SELECT
        lot.id,
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
 * Returns the number of active lots for a given category slug.
 *
 * @param mysqli      $connection     Active database connection
 * @param string|null $category_slug  Category slug (can be null)
 *
 * @return int Number of lots matching the category filter
 */
function getLotsCountByCategorySlug(mysqli $connection, ?string $category_slug): int {
    $category_slug = mysqli_real_escape_string($connection, (string)$category_slug);

    $sql = "SELECT
        COUNT(*) as cnt
        FROM lot
        JOIN category ON category.id = lot.category_id
        WHERE lot.expire_date > NOW()
            AND category.slug = '$category_slug'";

    $result = fetchOne($connection, $sql);
    return (int)($result['cnt'] ?? 0);
}

/**
 * Get all lots by category
 *
 * @param mysqli      $connection     Active database connection
 * @param string|null $category_slug  Category slug (can be null)
 *
 * @return array
 */
function getLotsByCategorySlug(mysqli $connection, ?string $category_slug, int $limit, int $offset): array {
    $category_slug = mysqli_real_escape_string($connection, (string)$category_slug);

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
    AND category.slug = '$category_slug'
    ORDER BY lot.created_at DESC
    LIMIT $limit OFFSET $offset";

    return fetchAll($connection, $sql);
}

/**
 * Gets the total number of lots found by a search query
 *
 * @param mysqli $connection Active database connection
 * @param string $value      Search query string
 *
 * @return int
 */
function getLotsCountBySearch(mysqli $connection, string $value): int {
    $sql = "SELECT
        COUNT(*) as cnt
    FROM `lot`
    JOIN `category` ON category.id = lot.category_id
    WHERE MATCH(lot.title,lot.description) AGAINST(?)";

    $stmt = db_get_prepare_stmt($connection, $sql, [$value]);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    return (int)($row['cnt'] ?? 0);
}

/**
 * Gets lots by search query using full-text search
 *
 * @param mysqli $connection Active database connection
 * @param string $value      Search query string
 *
 * @return array List of found lots
 */
function getAllLotsBySearch(mysqli $connection, string $value, int $limit, int $offset): array {
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
    LIMIT $limit OFFSET $offset";

    $stmt = db_get_prepare_stmt($connection, $sql, [$value]);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Adding lot data from the form to the database
 *
 * @param mysqli $connection Active database connection
 * @param array  $data       Associative array of lot data for insertion
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
