<?php

/** @var string $title */
/** @var string $page_content */
/** @var string $is_auth */
/** @var string $user_name */
/** @var array $categories */

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link href="assets/css/normalize.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="page-wrapper">

        <?= include_template('layout/_header.php',compact('is_auth', 'user_name')); ?>

        <main class="container"><?= $page_content ?></main>
    </div>

    <?= include_template('layout/_footer.php', compact('categories')); ?>

    <script src="assets/js/flatpickr.js"></script>
    <script src="assets/js/ru.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
