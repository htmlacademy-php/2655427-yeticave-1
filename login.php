<?php

declare(strict_types=1);

require_once 'init.php';

use enum\HttpMethodEnum;

/** @var mysqli $con */
/** @var bool $is_auth */
/** @var string $user_name */
/** @var array  $users */
/** @var array  $categories */

$errors = [];
$form_data = [];

$auth_users = indexByEmail('email', 'password_hash', $users);

if ($_SERVER['REQUEST_METHOD'] === HttpMethodEnum::POST->value) {
    $form_data = array_map('trim', $_POST);

    validateFormData(VALIDATION_RULES[LOGIN_FORM_KEY], $form_data, $errors);

    if (empty($errors)) {
        validateLoginPassword($auth_users, $form_data, $errors);
    }

    $errors = array_filter($errors);

    session_start();

    if (empty($errors)) {
        $found_user = null;

        foreach ($users as $current_user => $user) {
            if ($user['email'] === $form_data['email']) {
                $found_user = $user;
                break;
            }
        }

        if ($found_user) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name']
            ];
            header("Location: index.php");
            exit;
        }
    }
}

$page_content = include_template('login.php', compact(
    'categories',
    'users',
    'errors'
));

/** @noinspection PhpPipeOperatorCanBeUsedInspection */
$layout_content = include_template('layout/main.php', array_merge(
    [
        'title'     => 'Вход'
    ],
    compact(
        'is_auth',
        'user_name',
        'page_content',
        'categories'
    )
));

print($layout_content);
