<?php

declare(strict_types=1);

require_once 'init.php';
use enum\HttpStatusCodeEnum;

/** @var array  $categories */
/** @var array  $user */
/** @var mysqli $con */

$id = intval(filter_input(INPUT_GET, 'id'));
$lot = getLotById($con, $id);

if (!$lot) {
    http_response_code(HttpStatusCodeEnum::HttpNotFound->value);
    exit();
}

$page_content = include_template('lot.php', compact(
    'categories',
    'lot'
));

$layout_content = include_template('layout/main.php', array_merge(
    [
        'title'     => $lot['title'],
        'is_auth'   => $user['is_auth'],
        'user_name' => $user['user_name']
    ],
    compact(
        'page_content',
        'categories'
    )
));

print($layout_content);
