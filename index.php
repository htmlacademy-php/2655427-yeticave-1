<?php

declare(strict_types=1);

require_once 'init.php';

/** @var array $categories */
/** @var array $lots */

$is_auth = rand(0, 1);
$user_name = 'Виктория';
$title = 'Главная';

$page_content = include_template('index.php', compact(
    'categories',
    'lots'
));

$layout_content = include_template('layout/main.php', compact(
    'title',
    'is_auth',
    'user_name',
    'page_content',
    'categories'
));

print($layout_content);
