<?php

declare(strict_types=1);

/**
 * Validates required form fields and applies validation rules
 *
 * @param array $form_data An associative array of form data
 * @param array $errors Array of errors
 *
 * @return void
 */
function validateRequiredFields(array $data, array &$form_data, array &$errors): void {
    foreach ($form_data as $key => $value) {
        if ($value === '') {
            $errors[$key] = 'Заполните поле';
            continue;
        }
        $errors[$key] = array_key_exists($key, $data) ? $data[$key]($value) : null;
    }
}
