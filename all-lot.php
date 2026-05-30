<?php

declare(strict_types=1);

require_once 'init.php';

/** @var array  $categories */
/** @var array  $user */
/** @var mysqli $con */

$category_slug = filter_input(INPUT_GET, 'category');
$category_lots = getLotsByCategory($con, $category_slug);
$category_name = getCategoryName($con, $category_slug);

$page_content = include_template('all-lot.php', compact(
    'category_slug',
    'category_lots',
    'category_name',
    'categories'
));

/** @noinspection PhpPipeOperatorCanBeUsedInspection */
$layout_content = include_template('layout/main.php', array_merge(
    [
        'title'     => 'Все лоты',
        'is_auth'   => $user['is_auth'],
        'user_name' => $user['user_name']
    ],
    compact(
        'page_content',
        'categories'
    )
));

print($layout_content);
