<?php

declare(strict_types=1);

/**
 * Prepared data for filling in the form fields when adding a new lot
 *
 * @param array $form_data
 * @param array $user ID of the registered user
 *
 * @return array
 */
function prepareLotData(array $form_data, array $user = []): array {
    return [
        $form_data['lot-name'],
        $form_data['message'],
        $form_data['lot-rate'],
        $form_data['lot-date'],
        $form_data['lot-step'],
        (int)$form_data['category'],
        $form_data['lot-img'],
        (int) ($user['id'] ?? 1)
    ];
}

/**
 * Prepared data for the fields of the user registration form
 *
 * @param array $form_data
 *
 * @return array
 */
function prepareUserData(array $form_data): array {
    return [
        $form_data['email'],
        $form_data['name'],
        password_hash($form_data['password'], PASSWORD_DEFAULT),
        $form_data['message']
    ];
}

/**
 * Сreate a list of registered users by email and password hash
 *
 * @param string $email
 * @param string $password_hash
 * @param array $data
 *
 * @return array
 */
function indexByEmail($email, $password_hash, $data): array {
    $result = [];

    foreach ($data as $field) {
        $result[$field[$email]] = $field[$password_hash];
    }
    return $result;
}
