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
    <link href="../css/normalize.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <div class="page-wrapper">

        <?= include_template('header.php',compact('is_auth', 'user_name')); ?>

        <main class="container"><?= $page_content ?></main>
    </div>

    <?= include_template('footer.php', compact('categories')); ?>

    <script src="flatpickr.js"></script>
    <script src="script.js"></script>
</body>
</html>
