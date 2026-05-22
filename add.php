<?php

declare(strict_types=1);

require_once 'init.php';
use enum\HttpMethodEnum;

/** @var array  $categories */
/** @var array  $user */
/** @var mysqli $con */

$category_id = array_column($categories, 'id');
$allowed_types = ['image/png', 'image/jpeg'];
$errors = [];
$form_data = [];

if ($_SERVER['REQUEST_METHOD'] === HttpMethodEnum::POST->value) {
    $form_data = array_map('trim', $_POST);

    $rules = [
        'category' => fn($value) => validateCategory((int)$value, $category_id),
        'lot-rate' => 'validatePositiveInt',
        'lot-step' => 'validatePositiveInt',
        'lot-date' => 'validateDate',
    ];

    validateMissingDate($rules, $form_data, $errors);

    $errors = array_filter($errors);

    validateImage($errors, $allowed_types, $form_data);

    if (empty($errors)) {
        $params = [
            $form_data['lot-name'],
            $form_data['message'],
            $form_data['lot-rate'],
            $form_data['lot-date'],
            $form_data['lot-step'],
            $form_data['category'],
            $form_data['lot-img']
        ];

        $res = addLot($con, $params);

        if ($res) {
            $lot_id = mysqli_insert_id($con);
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
