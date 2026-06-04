<?php

declare(strict_types=1);

require_once 'init.php';

use enum\HttpStatusCodeEnum;

/** @var mysqli $con */
/** @var bool $is_auth */
/** @var string $user_name */
/** @var int|null $user_id */
/** @var array  $categories */

$lot_id = intval(filter_input(INPUT_GET, 'id'));
$lot = getLotById($con, $lot_id);
$bids = getBidsByLotId($con, $lot_id);
$last_bid = $bids[0] ?? null;

if (!$lot) {
    http_response_code(HttpStatusCodeEnum::HttpNotFound->value);
    exit();
}

$page_content = include_template('lot.php', compact(
    'is_auth',
    'user_id',
    'categories',
    'lot',
    'bids',
    'last_bid'
));

/** @noinspection PhpPipeOperatorCanBeUsedInspection */
$layout_content = include_template('layout/main.php', array_merge(
    [
        'title'     => $lot['title']
    ],
    compact(
        'is_auth',
        'user_name',
        'page_content',
        'categories'
    )
));

print($layout_content);
