<?php

declare(strict_types=1);

require_once 'init.php';

/** @var array $categories */
/** @var array $lots */

$id = intval(filter_input(INPUT_GET, 'id'));
$lot = getLotById($con, $id);

if (!$id) {
    http_response_code(404);
    exit();

}

if (!$lot) {
    http_response_code(404);
    exit();
}

$is_auth = rand(0, 1);
$user_name = 'Виктория';
$title = $lot['title'];

$page_content = include_template('lot.php', compact(
    'categories',
    'lot'
));

$layout_content = include_template('layout/main.php', compact(
    'title',
    'is_auth',
    'user_name',
    'page_content',
    'categories'
));

print($layout_content);
