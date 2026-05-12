<?php

declare(strict_types=1);

require_once 'init.php';
require_once 'functions/functions_db.php';

$is_auth = rand(0, 1);
$user_name = 'Виктория';
$title = 'Главная';

$page_content = include_template('main.php', compact(
    'categories',
    'lots'
));

$layout_content = include_template('layout/layout.php', compact(
    'title',
    'is_auth',
    'user_name',
    'page_content',
    'categories'
));

print($layout_content);
