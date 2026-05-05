<?php

/** @var array $categories */
/** @var array $lots */

?>
<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">

        <?php foreach($categories as $category): ?>
            <li class="promo__item promo__item--<?= esc($category['slug']) ?>">
                <a class="promo__link" href="pages/all-lots.html"><?= esc($category['name']) ?></a>
            </li>
        <?php endforeach; ?>

    </ul>
</section>

<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
        <ul class="lots__list">

            <?php foreach($lots as $lot): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img
                            src="<?= esc($lot['img_url'] ?? '') ?>"
                            width="350"
                            height="260"
                            alt=""
                        >
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= esc($lot['category'] ?? '') ?></span>
                        <h3 class="lot__title">
                            <a class="text-link" href="pages/lot.html"><?= esc($lot['title'] ?? '') ?></a>
                        </h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= esc(formatPrice($lot['price']) ?? 0) ?></span>
                            </div>

                            <?php [$hours, $minutes] = getRemainingTime(esc($lot['end_date'] ?? '')); ?>

                            <div class="lot__timer timer <?= $hours < 1 ? 'timer--finishing' : '' ?> ">
                                <?= sprintf('%02d:%02d', $hours, $minutes) ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>

        </ul>
</section>
