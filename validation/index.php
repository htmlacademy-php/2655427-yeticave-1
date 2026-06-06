<?php

declare(strict_types=1);

/**
 * Validates form fields according to the specified validation rules
 * Fills the errors array with validation messages
 *
 * @param array $rules Validation rules for form fields
 * @param array $form_data The form's data array
 * @param array $errors Array of errors
 * @param array $allowed_list List of valid categories for category validation
 *
 * @return void
 */
function validateFormData(array $rules, array $form_data, array &$errors, array $allowed_list = []): void {

    foreach ($rules as $field => $validators) {

        $value = $form_data[$field] ?? '';

        foreach ($validators as $rule) {

            $error = validateByRule($rule, $value, $allowed_list);

            if ($error !== null) {
                $errors[$field] = $error;
                break;
            }
        }
    }
}

/**
 * Converts a validator parameter string into an associative array
 *
 * @param string $params_string
 *
 * @return array
 */
function parseValidatorParams(string $params_string): array {
    $params = [];

    $pairs = explode(
        VALIDATOR_PARAMS_SEPARATOR,
        $params_string
    );

    $key = $parts[0] ?? null;
    $value = $parts[1] ?? null;

    if ($key !== null && $value !== null) {
        foreach ($pairs as $pair) {
            [$key, $value] = explode(
                VALIDATOR_PARAM_VALUE_SEPARATOR,
                $pair
            );
            $params[$key] = $value;
        }
    }
    return $params;
}

/**
 * Parses a validation rule, extracts validator parameters
 * Executes the corresponding validation function
 *
 * @param string $rule Validation rules for form fields
 * @param string $value Data to validate
 *
 * @return string|null
 */
function validateByRule(string $rule, string $value, array $allowed_list): ?string {

    $parts = explode(VALIDATOR_SEPARATOR, $rule);

    $validator = $parts[0];

    $params_string = $parts[1] ?? '';
    $params = [];

    if ($params_string !== ''){
        $params = parseValidatorParams($params_string);
    }

    $result = null;

    switch ($validator) {
        case 'required':
            $result = checkingEmptyField($value);
            break;

        case 'int':
            $result = validatePositiveInt($value, $params);
            break;

        case 'string':
            $result = validateText($value, $params);
            break;

        case 'date':
            $result = validateDate($value, $params);
            break;

        case 'category':
            $result = validateCategory($value, $allowed_list);
            break;

        case 'unique_email':
            $result = validateUniqueEmail($allowed_list);
            break;

        case 'email':
            $result = validateEmailFormat($value);
            break;

        case 'password':
            $result = validatePassword($value);
            break;

        case 'name':
            $result = validateName($value);
            break;
    }
    return $result;
}

/**
 * Validates email and password when a user logs in
 *
 * @param array $users_by_email User information by email
 * @param array $form_data The form's data array
 * @param array $errors Array of errors
 *
 * @return void
 */
function validateLoginPassword(array $users_by_email, array $form_data, array &$errors): void {
    define('PASSWORD_FIELD', 'password');
    define('EMAIL_FIELD', 'email');

    $email = $form_data[EMAIL_FIELD];

    if (!$users_by_email) {
        $errors[EMAIL_FIELD] = "Пользователя с таким email не существует";
        return;
    }

    if (!isset($errors['password'])) {
        if (!password_verify($form_data[PASSWORD_FIELD], $users_by_email['password_hash'])) {
            $errors[PASSWORD_FIELD] = "Указан невeрный пароль";
            return;
        }
    }
}
