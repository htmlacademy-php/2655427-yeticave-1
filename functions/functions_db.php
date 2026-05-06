<?php

declare(strict_types=1);

/** @var mysqli $con */

$lots = [];
$categories = [];

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

$result_lots = mysqli_query($con, $sql_lots);

if ($result_lots) {
    $lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
}
else {
    $error = mysqli_error($con);
    $content = include_template('error.php', ['error' => $error]);
}

// Get all categories
$sql_categories = "SELECT `id`, `name`, `slug` FROM category";
$result_categories = mysqli_query($con, $sql_categories);

if ($result_categories) {
    $categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);
}
else {
    $error = mysqli_error($con);
    $content = include_template('error.php', ['error' => $error]);
}
