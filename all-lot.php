<?php

declare(strict_types=1);

require_once 'init.php';

/** @var array $categories */
/** @var array $lots */

$is_auth = rand(0, 1);
$user_name = 'Виктория';
$title = 'Все лоты';

$category_slug = filter_input(INPUT_GET, 'category');
$categories_id = getLotsByCategory($con, $category_slug);

$page_content = include_template('all-lot.php', compact(
    'category_slug',
    'categories_id',
    'categories'
));

$layout_content = include_template('layout/main.php', compact(
    'title',
    'is_auth',
    'user_name',
    'page_content',
    'categories'
));

print($layout_content);
