<?php

/** @var array $categories */
/** @var array $found_lots */
/** @var string $search_value */

?>

<nav class="nav">
    <ul class="nav__list container">

        <?= include_template('_partials/nav.php', array_merge(
            [
                'mode' => 'footer'
            ],
            compact(
                'categories'
            )
        )); ?>

    </ul>
</nav>

<div class="container">
    <section class="lots">

        <?php if (!empty($found_lots)): ?>
            <h2>Результаты поиска по запросу «<span><?= $search_value ?></span>»</h2>
        <?php else: ?>
            <h2>Ничего не найдено по вашему запросу</h2>
        <?php endif; ?>

        <ul class="lots__list">

            <?php foreach($found_lots as $lot): ?>
                <?= include_template('_partials/lot-cards.php', compact('lot')) ?>
            <?php endforeach; ?>

        </ul>
    </section>
    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <li class="pagination-item pagination-item-active"><a>1</a></li>
        <li class="pagination-item"><a href="#">2</a></li>
        <li class="pagination-item"><a href="#">3</a></li>
        <li class="pagination-item"><a href="#">4</a></li>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
    </ul>
</div>
