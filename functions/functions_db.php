<?php

declare(strict_types=1);

function fetchAll(mysqli $con, string $sql_query): array {
    $result = mysqli_query($con, $sql_query);

    if (!$result) {
        error_log(mysqli_error($con));
        return [];
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function fetchOne(mysqli $con, string $sql_query): array|null {
    $result = mysqli_query($con, $sql_query);

    if (!$result) {
        error_log(mysqli_error($con));
        return null;
    }
    return mysqli_fetch_assoc($result);
}

// Get the newest open lots
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

// Get all categories
function getAllCategories(mysqli $connection): array {
    $sql = "SELECT `id`, `name`, `slug` FROM category";

    return fetchAll($connection, $sql);
}

// Get information about a lot by id
function getLotById(mysqli $connection, int $id): array|null {
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

// Get all lots by category
function getLotsByCategory(mysqli $connection, ?string $category_slug): array {
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
