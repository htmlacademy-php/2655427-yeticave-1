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
        return "Минимальная длина поля $min_characters символов";
    }

    if ($max_characters !== 0 && $string_length > $max_characters) {
        return "Максимальная длина поля $max_characters символов";
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
    $format = $params['format'] ?? 'Y-m-d';
    $day = $params['gt'] ?? null;

    $dateTime = date_create_from_format($format, $date);

    if (
        $dateTime === false ||
        $dateTime->format($format) !== $date
    ) {
        return "Введите дату в формате «ГГГГ-ММ-ДД»";
    }

    if ($day === 'today') {
        $today = new DateTimeImmutable('tomorrow');

        if ($dateTime <= $today) {
            return "Дата должна быть больше текущей минимум на 1 день";
        }
    }
    return null;
}

/**
 * Checks whether the category exists in the list of allowed categories
 *
 * @param array $allowed_list List of valid categories for category validation
 * @param string $category
 *
 * @return string|null Error message or null
 */
function validateCategory(string $category, array $allowed_list): ?string {
    $id = (int)$category;

    if (!in_array($id, $allowed_list)) {
        return "Указана несуществующая категория";
    }
    return null;
}

/**
 * Checking the correctness of the email addresses and its uniqueness
 *
 * @param array $allowed_list List of existing email addresses in the database
 * @param string $email
 *
 * @return string|null Error message or null
 */
function validateEmail(string $email, array $allowed_list): ?string {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Неверный email";
    }

    if (in_array($email, $allowed_list)) {
       return "Указанный email уже используется другим пользователем";
    }
    return null;
}

/**
 * Only letters and numbers are allowed in the password
 *
 * @param string $password
 *
 * @return string|null Error message or null
 */
function validatePassword(string $password): ?string {
    if (!preg_match("/^[a-zA-Z\d]+$/", $password)) {
        return "Разрешены только буквы и цифры";
    }

    if (!preg_match("/[a-z]/", $password)) {
        return "Пароль должен содержать хотя бы одну строчную букву";
    }

    if (!preg_match("/[A-Z]/", $password)) {
        return "Пароль должен содержать хотя бы одну заглавную букву";
    }

    if (!preg_match("/\d/", $password)) {
        return "Пароль должен содержать хотя бы одну цифру";
    }
    return null;
}

/**
 * User name validation
 *
 * @param string $name
 *
 * @return string|null Error message or null
 */
function validateName(string $name): ?string {
    if (!preg_match("/^[\p{L}\- ]+$/u", $name)) {
        return "Некорректное имя пользователя";
    }
    return null;
}

/**
 * Validates the uploaded image
 *
 * @param array $errors Array of errors
 * @param array $data The form's data array
 *
 * @return void
 */
function processLotImage(array &$errors, array &$data): void {
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
        !in_array($file_type, ALLOWED_IMAGE_MIME_TYPES, true) ||
        !in_array($extension, ALLOWED_IMAGE_EXTENSIONS, true)
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
