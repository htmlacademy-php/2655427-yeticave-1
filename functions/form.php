<?php

declare(strict_types=1);

/**
 * Parameters of the form fields
 *
 * @param array $form_data
 *
 * @return array $user ID of the registered user
 */
function parametersOfFormFields(array $form_data, array $user = []): array {
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
