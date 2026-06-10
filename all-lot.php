<?php

declare(strict_types=1);

require_once 'init.php';

/** @var mysqli $con */
/** @var array $auth_user */
/** @var array  $categories */

$category_slug = filter_input(INPUT_GET, 'category');

$per_page = 6;
$page = max(1, (int)($_GET['page'] ?? 1));

$total = getLotsCountByCategorySlug($con, $category_slug);
$pagination = getPaginationData($per_page, $page, $total);
$page = $pagination['page'];

$category_lots = getLotsByCategorySlug($con, $category_slug, $per_page, $pagination['offset']);
$category_name = getCategoryName($con, $category_slug);


$page_content = include_template('all-lot.php',  array_merge(
    [
        'query' => [
            'category' => $category_slug
        ]
    ],
    compact(
        'category_slug',
        'category_lots',
        'category_name',
        'categories',
        'page',
        'pagination'
    )
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
