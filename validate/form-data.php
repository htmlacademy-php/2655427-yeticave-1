<?php

declare(strict_types=1);

/**
 * Checks whether the category exists in the list of allowed categories
 *
 * @param int $id ID category
 * @param array $allowed_list List of valid categories for category validation
 *
 * @return string|null Error message or null
 */
function validateCategory(int $id, array $allowed_list): ?string {
    if (!in_array($id, $allowed_list)) {
        return "Указана несуществующая категория";
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
function validatePositiveInt(string $value): ?string {
    if (!preg_match('/^[1-9]\d*$/', $value)) {
        return "Введите целое значение больше нуля";
    }
    return null;
}

/**
 * Checks the correctness of the date and its compliance with the form requirements
 *
 * @param string $date Date in the format "YYYY-MM-DD"
 *
 * @return string|null Error message or null
 */
function validateDate(string $date): ?string {
    $format = 'Y-m-d';

    $dateTime = date_create_from_format($format, $date);

    if (
        $dateTime === false ||
        $dateTime->format($format) !== $date
    ) {
        return "Введите дату в формате «ГГГГ-ММ-ДД»";
    }

    $tomorrow = new DateTimeImmutable('tomorrow');

    if ($dateTime < $tomorrow) {
        return "Дата должна быть больше текущей минимум на 1 день";
    }

    return null;
}

/**
 * Validates the uploaded image
 *
 * @param array $errors Array of errors
 * @param array $type Allowed MIME types (image/jpeg, image/png)
 * @param array $data The form's data array
 *
 * @return void
 */
function validateImage(array &$errors, array $type, array &$data): void {
    if (empty($_FILES['lot-img']['name'])) {
        $errors['lot-img'] = "Вы не загрузили файл";
        return;
    }

    if ($_FILES['lot-img']['size'] > 5 * 1024 * 1024) {
        $errors['lot-img'] = "Файл слишком большой (макс. 5 MB)";
        return;
    }

    $tmp_name = $_FILES['lot-img']['tmp_name'];
    $file_type = mime_content_type($tmp_name);

    if (!in_array($file_type, $type, true)) {
        $errors['lot-img'] = "Загрузите картинку в формате .png или .jpeg";
        return;
    }

    $extension = pathinfo($_FILES['lot-img']['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $extension;

    if (move_uploaded_file($tmp_name, 'uploads/' . $filename)) {
        $data['lot-img'] = 'uploads/' . $filename;
    } else {
        $errors['lot-img'] = "Ошибка загрузки файла";
    };
}
