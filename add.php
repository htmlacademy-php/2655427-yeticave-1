<?php

declare(strict_types=1);

require_once 'init.php';

use enum\HttpMethodEnum;

/** @var array  $categories */
/** @var array  $user */
/** @var mysqli $con */

$errors = [];
$form_data = [];

if ($_SERVER['REQUEST_METHOD'] === HttpMethodEnum::POST->value) {
    $form_data = array_map('trim', $_POST);
    $category_id = array_column($categories, 'id');

    validateFormData(VALIDATION_RULES[ADD_LOT_FORM_KEY], $form_data, $errors);
    validateCategory($form_data, $category_id, $errors);

    $errors = array_filter($errors);

    processLotImage($errors, ALLOWED_IMAGE_MIME_TYPES, ALLOWED_IMAGE_EXTENSIONS, $form_data);

    if (empty($errors)) {

        $params = parametersOfFormFields($form_data);
        $lot_id = addLot($con, $params);

        if ($lot_id){
            header("Location: lot.php?id=" . $lot_id);
            exit();
        }
    }
}

$page_content = include_template('add-lot.php', compact(
    'form_data',
    'errors',
    'categories'
));

$layout_content = include_template('layout/main.php', array_merge(
    [
        'title'     => 'Добавление лота',
        'is_auth'   => $user['is_auth'],
        'user_name' => $user['user_name']
    ],
    compact(
        'page_content',
        'categories'
    )
));

print($layout_content);
