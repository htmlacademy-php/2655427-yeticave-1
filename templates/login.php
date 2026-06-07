<?php

/** @var array $categories */
/** @var array $errors */
/** @var array $form_data */

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

<form
    class="form container <?= !empty($errors) ? 'form--invalid' : '' ?>"
    action="login.php"
    method="post"
    autocomplete="off"
>
    <h2>Вход</h2>
    <div class="form__item <?= isset($errors['email']) ? "form__item--invalid" : '' ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input
            id="email"
            type="text"
            name="email"
            placeholder="Введите e-mail"
            value="<?= esc($form_data['email'] ?? ''); ?>"
        >
        <span class="form__error"><?= $errors['email'] ?></span>
    </div>
    <div class="form__item form__item--last <?= isset($errors['password']) ? "form__item--invalid" : '' ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input
            id="password"
            type="password"
            name="password"
            placeholder="Введите пароль"
            value="<?= esc($form_data['password'] ?? ''); ?>"
        >
        <span class="form__error"><?= $errors['password'] ?></span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>
