<?php

declare(strict_types=1);

/** @var mysqli $con */

$lots = [];
$categories = [];
$lot_card = [];

// Get the newest open lots
$sql_lots = "SELECT
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

$lots = fetchAll($con, $sql_lots);


// Get all categories
$sql_categories = "SELECT `id`, `name`, `slug` FROM category";

$categories = fetchAll($con, $sql_categories);


// Get information about a lot by id
$id = intval(filter_input(INPUT_GET, 'id'));

$sql_lot_id = "SELECT
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

$lot_card = fetchOne($con, $sql_lot_id );


// Get all lots by category
$category_slug = filter_input(INPUT_GET, 'category');

$sql_category_slug = "SELECT
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

$categories_id = fetchAll($con, $sql_category_slug);
