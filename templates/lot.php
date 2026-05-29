<?php

/** @var array $categories */
/** @var array|null $lot */
/** @var array|null $history_bids */


?>

<nav class="nav">
    <ul class="nav__list container">

        <?php
            $mode = 'footer';
            include 'templates/_partials/nav.php';
        ?>

    </ul>
</nav>

<section class="lot-item container">
    <h2><?= esc($lot['title'] ?? '') ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= esc($lot['img_url'] ?? '') ?>"
                    width="730"
                    height="548"
                    alt="Сноуборд"
                >
            </div>
            <p class="lot-item__category">Категория:
                <span>
                    <?= esc($lot['category_name'] ?? '') ?>
                </span>
            </p>
            <p class="lot-item__description"><?= esc($lot['description'] ?? '') ?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">

                <?php [$hours, $minutes] = getRemainingTime(esc($lot['expire_date'] ?? '')); ?>

                <div class="lot-item__timer timer <?= $hours < 1 ? 'timer--finishing' : '' ?> ">
                    <?= sprintf('%02d:%02d', $hours, $minutes) ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?= formatPrice(esc($lot['current_price'] ?? '')) ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= formatPrice(esc($lot['current_price'] + $lot['bid_step'] ?? '')) ?></span>
                    </div>
                </div>
                <form class="lot-item__form"
                    action="https://echo.htmlacademy.ru"
                    method="post"
                    autocomplete="off"
                >
                    <p class="lot-item__form-item form__item form__item--invalid">
                        <label for="cost">Ваша ставка</label>
                            <input id="cost"
                                type="text"
                                name="cost"
                                placeholder="<?= formatPrice(esc($lot['current_price'] + $lot['bid_step'] ?? '')) ?>"
                            >
                            <span class="form__error">Вы не сделали ставку</span>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <div class="history">
                <h3>История ставок (<span><?= count($history_bids) ?></span>)</h3>
                <table class="history__list">

                    <?php foreach ($history_bids as $bid): ?>
                        <tr class="history__item">
                            <td class="history__name"><?= $bid['user_name'] ?></td>
                            <td class="history__price"><?= $bid['amount'] ?> р</td>
                            <td class="history__time"><?= $bid['created_at'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>
