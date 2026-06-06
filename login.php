<?php

declare(strict_types=1);

require_once 'init.php';

use enum\HttpStatusCodeEnum;
use enum\HttpMethodEnum;

/** @var mysqli $con */
/** @var bool $auth_user */
/** @var array  $categories */

if (isset($auth_user['id'])) {
    http_response_code(HttpStatusCodeEnum::HttpForbidden->value);
    exit();
}

$errors = [];
$form_data = [];

if ($_SERVER['REQUEST_METHOD'] === HttpMethodEnum::POST->value) {
    $form_data = array_map('trim', $_POST);
    $user = getUserByEmail($con, $form_data['email']);

    validateFormData(VALIDATION_RULES[LOGIN_FORM_KEY], $form_data, $errors);

    if (empty($errors)) {
        validateLoginPassword($user, $form_data, $errors);
    }

    $errors = array_filter($errors);

    if (empty($errors)) {
        $_SESSION['user'] = [
            'id'   => $user['id'],
            'name' => $user['name']
        ];
        header("Location: index.php");
        exit;
    }
}


$page_content = include_template('login.php', compact(
    'categories',
    'errors'
));

/** @noinspection PhpPipeOperatorCanBeUsedInspection */
$layout_content = include_template('layout/main.php', array_merge(
    [
        'title' => 'Вход'
    ],
    compact(
        'auth_user',
        'page_content',
        'categories'
    )
));

print($layout_content);
