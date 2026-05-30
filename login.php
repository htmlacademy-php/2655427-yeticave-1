<?php

declare(strict_types=1);

require_once 'init.php';

/** @var array  $categories */
/** @var array  $user */
/** @var mysqli $con */

$page_content = include_template('login.php', compact(
    'categories'
));

/** @noinspection PhpPipeOperatorCanBeUsedInspection */
$layout_content = include_template('layout/main.php', array_merge(
    [
        'title'     => 'Вход',
        'is_auth'   => $user['is_auth'],
        'user_name' => $user['user_name']
    ],
    compact(
        'page_content',
        'categories'
    )
));

print($layout_content);