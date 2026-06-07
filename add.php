<?php

declare(strict_types=1);

require_once 'init.php';

use enum\HttpMethodEnum;
use enum\HttpStatusCodeEnum;

/** @var mysqli $con */
/** @var bool $auth_user */
/** @var array  $categories */

if (!isset($auth_user['id'])) {
    http_response_code(HttpStatusCodeEnum::HttpForbidden->value);
    exit();
}

$errors = [];
$form_data = [];

if ($_SERVER['REQUEST_METHOD'] === HttpMethodEnum::POST->value) {
    $form_data = array_map('trim', $_POST);
    $category_ids = array_column($categories, 'id');

    validateFormData(VALIDATION_RULES[ADD_LOT_FORM_KEY], $form_data, $errors, $category_ids);

    $errors = array_filter($errors);

    processLotImage($errors, $form_data);

    if (empty($errors)) {
        $data = prepareLotData($form_data);
        $lot_id = addLot($con, $data);

        if ($lot_id) {
            header("Location: lot.php?id=" . $lot_id);
            exit;
        }
    }
}

$page_content = include_template('add-lot.php', compact(
    'form_data',
    'errors',
    'categories'
));

/** @noinspection PhpPipeOperatorCanBeUsedInspection */
$layout_content = include_template('layout/main.php', array_merge(
    [
        'title' => 'Добавление лота'
    ],
    compact(
        'auth_user',
        'page_content',
        'categories'
    )
));

print($layout_content);
