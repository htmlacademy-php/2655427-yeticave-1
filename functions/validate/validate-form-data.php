<?php

declare(strict_types=1);

require_once 'functions/helpers.php';

function validateCategory(int $id, array $allowed_list): ?string {
    if (!in_array($id, $allowed_list)) {
        return "Указана несуществующая категория";
    }
    return null;
}

function validatePositiveInt(string $value): ?string {
    if (!preg_match('/^[1-9]\d*$/', $value)) {
        return "Введите целое значение больше нуля";
    }
    return null;
}

function validateDate(string $date): ?string {
    if (!is_date_valid($date)) {
        return "Введите дату в формате «ГГГГ-ММ-ДД»";
    }
    if ($date < date_create('tomorrow')) {
        return "Дата должна быть больше текущей минимум на 1 день";
    }
    return null;
}

function validateMissingDate(array &$data, array &$form_data, array &$errors): void {
    foreach ($data as $field => $validator) {
        $value = trim($form_data[$field] ?? '');

        if ($value === '') {
            $errors[$field] = 'Заполните поле';
            continue;
        }
        $errors[$field] = $validator($value);
    }
}
