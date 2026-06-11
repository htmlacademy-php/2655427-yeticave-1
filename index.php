<?php

declare(strict_types=1);

require_once 'init.php';

assignWinnerBids($con);

/** @var mysqli $con */
/** @var array $auth_user */
/** @var array  $categories */

$lots = getNewLots($con);

$page_content = include_template('index.php', compact(
    'categories',
    'lots'
));

/** @noinspection PhpPipeOperatorCanBeUsedInspection */
$layout_content = include_template('layout/main.php', array_merge(
    [
        'title' => 'Главная'
    ],
    compact(
        'auth_user',
        'page_content',
        'categories'
    )
));

print($layout_content);
