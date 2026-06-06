<?php

declare(strict_types=1);

require_once 'init.php';

use enum\HttpMethodEnum;

/** @var mysqli $con */
/** @var bool $is_auth */
/** @var string $user_name */
/** @var array  $categories */

$found_lots = [];
$search_value = '';

if ($_SERVER['REQUEST_METHOD'] === HttpMethodEnum::GET->value) {
    $search_value = trim($_GET['search'] ?? '');

    if ($search_value !== '') {
        $found_lots = getAllLotsBySearch($con, $search_value);
    }
}


$page_content = include_template('search.php', compact(
    'categories',
    'found_lots',
    'search_value'
));

/** @noinspection PhpPipeOperatorCanBeUsedInspection */
$layout_content = include_template('layout/main.php', array_merge(
    [
        'title' => 'Результаты поиска'
    ],
    compact(
        'is_auth',
        'user_name',
        'page_content',
        'categories'
    )
));

print($layout_content);
