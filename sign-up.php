<?php

declare(strict_types=1);

require_once 'init.php';

use enum\HttpMethodEnum;

/** @var mysqli $con */
/** @var bool $is_auth */
/** @var string $user_name */
/** @var array  $categories */

$errors = [];
$form_data = [];

if ($_SERVER['REQUEST_METHOD'] === HttpMethodEnum::POST->value) {
    $form_data = array_map('trim', $_POST);
    $emails = array_column(getAllUsers($con), 'email');

    validateFormData(VALIDATION_RULES[SIGN_UP_FORM_KEY], $form_data, $errors, $emails);

    $errors = array_filter($errors);

    if (empty($errors)) {
        $data = prepareUserData($form_data);
        $user_id = addUser($con, $data);

        if ($user_id) {
            header("Location: login.php");
            exit;
        }
    }
}

$page_content = include_template('sign-up.php', compact(
    'categories',
    'form_data',
    'errors'
));

/** @noinspection PhpPipeOperatorCanBeUsedInspection */
$layout_content = include_template('layout/main.php', array_merge(
    [
        'title'     => 'Регистрация'
    ],
    compact(
        'page_content',
        'categories',
        'is_auth',
        'user_name'
    )
));

print($layout_content);
