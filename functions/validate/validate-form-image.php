<?php

declare(strict_types=1);

function validateImage(array &$errors, array $type, array &$data): void {
    if (empty($_FILES['lot-img']['name'])) {
        $errors['lot-img'] = "Вы не загрузили файл";
    } else {
        $tmp_name = $_FILES['lot-img']['tmp_name'];
        $file_type = mime_content_type($tmp_name);

        if (!in_array($file_type, $type)) {
            $errors['lot-img'] = "Загрузите картинку в формате .png или .jpeg";
        } else {
            $img_url = $_FILES['lot-img']['name'];
            $extension = pathinfo($img_url, PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $extension;

            move_uploaded_file($tmp_name, 'uploads/' . $filename);

            $data['lot-img'] = $filename;
            }
    }
}
