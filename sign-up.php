<?php

declare(strict_types=1);

require_once 'init.php';

use enum\HttpMethodEnum;

/** @var array  $categories */
/** @var array  $user */
/** @var mysqli $con */

$email = getAllUsers($con);

$errors = [];
$form_data = [];

if ($_SERVER['REQUEST_METHOD'] === HttpMethodEnum::POST->value) {
    $form_data = array_map('trim', $_POST);
    $user_email = array_column($email, 'email');

    validateFormData(VALIDATION_RULES[SIGN_UP_FORM_KEY], $form_data, $errors, $user_email);

    $errors = array_filter($errors);

    if (empty($errors)) {
        $params = prepareUserData($form_data);
        $user_id = registerUser($con, $params);

        if ($user_id) {
            header("Location: index.php");
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
        'title'     => 'Регистрация',
        'is_auth'   => $user['is_auth'],
        'user_name' => $user['user_name']
    ],
    compact(
        'page_content',
        'categories'
    )
));

print($layout_content);
