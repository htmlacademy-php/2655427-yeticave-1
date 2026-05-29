<?php

declare(strict_types=1);

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

    foreach ($pairs as $pair) {
        [$key, $value] = explode(
            VALIDATOR_PARAM_VALUE_SEPARATOR,
            $pair
        );
        $params[$key] = $value;
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
function validateByRule(string $rule, string $value): ?string {

    $parts = explode(VALIDATOR_SEPARATOR, $rule);

    $validator = $parts[0];

    $params_string = $parts[1] ?? '';
    $params = [];

    if ($params_string !== ''){
        $params = parseValidatorParams($params_string);
    }

    switch ($validator) {
        case 'required':
            return checkingEmptyField($value);

        case 'int':
            return validatePositiveInt($value, $params);

        case 'date':
            return validateDate($value, $params);

        case 'string':
            return validateText($value, $params);

        default:
            return null;
    }
}

/**
 * Validates form fields according to the specified validation rules
 * Fills the errors array with validation messages
 *
 * @param array $rules Validation rules for form fields
 * @param array $form_data The form's data array
 * @param array $errors Array of errors
 *
 * @return void
 */
function validateFormData(array $rules, array $form_data, array &$errors): void {

    foreach ($rules as $field => $validators) {

        $value = trim($form_data[$field] ?? '');

        foreach ($validators as $rule) {

            $error = validateByRule($rule, $value);

            if ($error !== null) {
                $errors[$field] = $error;
            }
        }
    }
}
