<?php

declare(strict_types=1);

/**
 * Checks whether the field value is empty
 *
 * @param string $value
 *
 * @return string|null Error message or null
 */
function checkingEmptyField(string $value): ?string {
    if ($value === '') {
        return 'Заполните поле';
    }
    return null;
}

/**
 * Checks whether the value is positive and greater than zero
 *
 * @param string $value
 *
 * @return string|null Error message or null
 */
function validatePositiveInt(string $value, array $params): ?string {
    if (!preg_match('/^[1-9]\d*$/', $value)) {
        return "Введите целое значение больше нуля";
    }

    $min = (int)($params['min'] ?? 0);

    if ((int)$value < $min) {
        return "Минимальное значение: $min";
    }
    return null;
}

/**
 * Checks the correctness of the date and its compliance with the form requirements
 *
 * @param string $date Date in the format "YYYY-MM-DD"
 * @param array $params Validation parameters
 *
 * @return string|null Error message or null
 */
function validateDate(string $date, array $params): ?string {
    $format = $params['format'];
    $day = $params['gt'];

    $dateTime = date_create_from_format($format, $date);

    if (
        $dateTime === false ||
        $dateTime->format($format) !== $date
    ) {
        return "Введите дату в формате «ГГГГ-ММ-ДД»";
    }

    if ($day === 'today') {
        $tomorrow = new DateTimeImmutable('tomorrow');

        if ($dateTime < $tomorrow) {
            return "Дата должна быть больше текущей минимум на 1 день";
        }
    }
    return null;
}

/**
 * Validates text length according to character limits
 *
 * @param string $value Text value to validate
 * @param array $params Validation parameters
 *
 * @return string|null Validation error message or null if validation passes
 */
function validateText(string $value, array $params): ?string {
    $max_characters = (int)($params['max'] ?? 0);
    $min_characters = (int)($params['min'] ?? 0);
    $string_length = mb_strlen($value);

    if ($min_characters !== 0 && $string_length < $min_characters) {
        return "Минимальная длина теста $min_characters символов";
    }

    if ($max_characters !== 0 && $string_length > $max_characters) {
        return "Максимальная длина теста $max_characters символов";
    }
    return null;
}

/**
 * Checks whether the category exists in the list of allowed categories
 *
 * @param array $form_data The form's data array
 * @param array $allowed_list List of valid categories for category validation
 * @param array $errors Array of errors
 *
 * @return void
 */
function validateCategory(array &$form_data, array $allowed_list, array &$errors): void {
    define('CATEGORY_FIELD', 'category');

    $id = (int)($form_data[CATEGORY_FIELD] ?? 0);

    if (!in_array($id, $allowed_list)) {
        $errors[CATEGORY_FIELD] = "Указана несуществующая категория";
    }
}

/**
 * Validates the uploaded image
 *
 * @param array $errors Array of errors
 * @param array $type Allowed MIME types (image/jpeg, image/png)
 * @param array $allowed_extensions Acceptable file types
 * @param array $data The form's data array
 *
 * @return void
 */
function processLotImage(array &$errors, array $type, array $allowed_extensions, array &$data): void {
    define('LOT_IMAGE_FIELD', 'lot-img');

    if (empty($_FILES[LOT_IMAGE_FIELD]['name'])) {
        $errors[LOT_IMAGE_FIELD] = "Вы не загрузили файл";
        return;
    }

    if ($_FILES[LOT_IMAGE_FIELD]['size'] > 5 * 1024 * 1024) {
        $errors[LOT_IMAGE_FIELD] = "Файл слишком большой (макс. 5 MB)";
        return;
    }

    $tmp_name = $_FILES[LOT_IMAGE_FIELD]['tmp_name'];
    $file_type = mime_content_type($tmp_name);
    $extension = strtolower(pathinfo($_FILES[LOT_IMAGE_FIELD]['name'], PATHINFO_EXTENSION));

    if (
        !in_array($file_type, $type, true) ||
        !in_array($extension, $allowed_extensions, true)
    ) {
        $errors[LOT_IMAGE_FIELD] = "Допустимы файлы: .png, .jpg, .jpeg";
        return;
    }

    $filename = uniqid() . '.' . $extension;

    if (move_uploaded_file($tmp_name, 'uploads/' . $filename)) {
        $data[LOT_IMAGE_FIELD] = 'uploads/' . $filename;
    } else {
        $errors[LOT_IMAGE_FIELD] = "Ошибка загрузки файла";
    };
}
