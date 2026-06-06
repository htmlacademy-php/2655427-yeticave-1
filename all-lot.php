<?php

declare(strict_types=1);

require_once 'init.php';

/** @var mysqli $con */
/** @var bool $auth_user */
/** @var array  $categories */

$category_slug = filter_input(INPUT_GET, 'category');
$category_lots = getLotsByCategorySlug($con, $category_slug);
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
        'title' => 'Все лоты'
    ],
    compact(
        'auth_user',
        'page_content',
        'categories',
    )
));

print($layout_content);
