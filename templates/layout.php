<?php

/** @var string $title */
/** @var string $page_content */

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

        <?php require('header.php'); ?>

        <main class="container"><?= $page_content ?></main>
    </div>

<?php require('footer.php'); ?>

<script src="flatpickr.js"></script>
<script src="script.js"></script>
</body>
</html>
