<?php

declare(strict_types=1);

require_once 'init.php';
require_once 'functions/functions_db.php';

$is_auth = rand(0, 1);
$user_name = 'Виктория';
$title = 'Все лоты';

$page_content = include_template('all_lot.php', compact(
    'category_slug',
    'categories_id',
    'categories'
));

$layout_content = include_template('layout/layout.php', compact(
    'title',
    'is_auth',
    'user_name',
    'page_content',
    'categories'
));

print($layout_content);
