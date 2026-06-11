<?php

declare(strict_types=1);

require_once 'init.php';

use enum\HttpMethodEnum;

/** @var mysqli $con */
/** @var array $auth_user */
/** @var array  $categories */

$found_lots = [];

$page = max(1, (int)($_GET['page'] ?? 1));

$per_page = 9;
$pagination = [
    'total_pages' => 0,
    'offset' => 0,
    'page' => 1
];

if ($_SERVER['REQUEST_METHOD'] === HttpMethodEnum::GET->value) {
    $search_value = trim($_GET['search'] ?? '');

    if ($search_value !== '') {
        $total = getLotsCountBySearch($con, $search_value);
        $pagination = getPaginationData($per_page, $page, $total);
        $page = $pagination['page'];

        $found_lots = getAllLotsBySearch($con, $search_value, $per_page, $pagination['offset']);
    }
}

$page_content = include_template('search.php', array_merge(
    [
        'query' => [
            'search' => $search_value
        ]
    ],
    compact(
        'categories',
        'found_lots',
        'search_value',
        'pagination',
        'page'

    )
));

/** @noinspection PhpPipeOperatorCanBeUsedInspection */
$layout_content = include_template('layout/main.php', array_merge(
    [
        'title' => 'Результаты поиска'
    ],
    compact(
        'auth_user',
        'page_content',
        'categories',
        'search_value'
    )
));

print($layout_content);
