<?php

declare(strict_types=1);

require_once 'init.php';

/** @var mysqli $con */
/** @var bool $is_auth */
/** @var string $user_name */
/** @var array  $categories */

$lots = getNewLots($con);

$page_content = include_template('index.php', compact(
    'categories',
    'lots'
));

/** @noinspection PhpPipeOperatorCanBeUsedInspection */
$layout_content = include_template('layout/main.php', array_merge(
    [
        'title'     => 'Главная'
    ],
    compact(
        'is_auth',
        'user_name',
        'page_content',
        'categories'
    )
));

print($layout_content);
