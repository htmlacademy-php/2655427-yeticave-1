<?php

declare(strict_types=1);

<<<<<<< HEAD
require_once 'init.php';
require_once 'functions/functions_db.php';
=======
require_once 'util/constant.php';
require_once 'functions/functions.php';
require_once 'functions/helpers.php';
require_once 'init.php';

/** @var array $categories */
/** @var array $lots */
/** @var mysqli $con */
>>>>>>> master

$is_auth = rand(0, 1);
$user_name = 'Виктория';
$title = 'Главная';

<<<<<<< HEAD
$page_content = include_template('main.php', compact(
    'categories',
    'lots'
));

$layout_content = include_template('layout/layout.php', compact(
    'title',
    'is_auth',
    'user_name',
    'page_content',
    'categories'
));

=======
// Get the newest open lots
$sql_lots = "SELECT
    lot.id AS id,
    lot.title AS title,
    lot.start_price AS price,
    lot.img_url AS img_url,
    COALESCE(MAX(bid.amount), lot.start_price) AS current_price,
    category.name AS category,
    lot.expire_date AS end_date
FROM `lot`
LEFT JOIN `bid` ON bid.lot_id = lot.id
JOIN `category` ON lot.category_id = category.id
WHERE lot.expire_date >  NOW()
GROUP BY lot.id
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



$page_content = include_template('main.php', compact(
    'categories',
    'lots'
));

$layout_content = include_template('layout.php', compact(
    'title',
    'is_auth',
    'user_name',
    'page_content',
    'categories'
));

>>>>>>> master
print($layout_content);
