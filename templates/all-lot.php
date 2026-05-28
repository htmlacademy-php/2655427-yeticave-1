<?php

/** @var array $category_lots */
/** @var array $categories */
/** @var array $category_name */
/** @var string|null $category_slug */
?>

<nav class="nav">
    <ul class="nav__list container">

        <?php
            $mode = 'nav';
            include 'templates/_partials/nav.php';
        ?>

    </ul>
</nav>

<div class="container">
    <section class="lots">
        <h2>Все лоты в категории <span>«<?= $category_name['name'] ?>»</span></h2>
        <ul class="lots__list">

            <?php foreach($category_lots as $lot): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img
                            src="<?= esc($lot['img_url'] ?? '') ?>"
                            width="350"
                            height="260"
                            alt="Сноуборд"
                        >
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= esc($lot['category_name'] ?? '') ?></span>
                        <h3 class="lot__title">
                            <a class="text-link" href="lot.php?id=<?= esc($lot['lot_id'] ?? '') ?>"><?= esc($lot['title'] ?? '') ?></a>
                        </h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= esc(formatPrice($lot['start_price']) ?? 0) ?></span>
                            </div>

                            <?php [$hours, $minutes] = getRemainingTime(esc($lot['expire_date'] ?? '')); ?>

                            <div class="lot__timer timer <?= $hours < 1 ? 'timer--finishing' : '' ?> ">
                                <?= sprintf('%02d:%02d', $hours, $minutes) ?>
                            </div>
                        </div>
                    </div>
                </li>
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
