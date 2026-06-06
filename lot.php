<?php

declare(strict_types=1);

require_once 'init.php';

use enum\HttpStatusCodeEnum;

/** @var mysqli $con */
/** @var bool $auth_user */
/** @var array $categories */

$lot_id = intval(filter_input(INPUT_GET, 'id'));
$lot = getLotById($con, $lot_id);
$bids = getBidsByLotId($con, $lot_id);
$last_bid = $bids[0] ?? null;

if (!$lot) {
    http_response_code(HttpStatusCodeEnum::HttpNotFound->value);
    exit();
}

$page_content = include_template('lot.php', compact(
    'auth_user',
    'categories',
    'lot',
    'bids',
    'last_bid'
));

/** @noinspection PhpPipeOperatorCanBeUsedInspection */
$layout_content = include_template('layout/main.php', array_merge(
    [
        'title' => $lot['title']
    ],
    compact(
        'auth_user',
        'page_content',
        'categories'
    )
));

print($layout_content);
