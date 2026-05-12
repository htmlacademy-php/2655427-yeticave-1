<?php

declare(strict_types=1);

require_once 'init.php';
require_once 'functions/functions_db.php';

if (!$id) {
    http_response_code(404);
    exit();

}

if (!$lot_card) {
    http_response_code(404);
    exit();
}

$is_auth = rand(0, 1);
$user_name = 'Виктория';
$title = $lot_card['title'];

$page_content = include_template('lot.php', compact(
    'categories',
    'lot_card'
));

$layout_content = include_template('layout/layout.php', compact(
    'title',
    'is_auth',
    'user_name',
    'page_content',
    'categories'
));

print($layout_content);
