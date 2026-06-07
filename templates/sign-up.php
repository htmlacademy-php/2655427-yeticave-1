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
    action="sign-up.php"
    method="post"
    autocomplete="off"
>
    <h2>Регистрация нового аккаунта</h2>
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
    <div class="form__item <?= isset($errors['password']) ? "form__item--invalid" : '' ?>">
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
    <div class="form__item <?= isset($errors['name']) ? "form__item--invalid" : '' ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input
            id="name"
            type="text"
            name="name"
            placeholder="Введите имя"
            value="<?= esc($form_data['name'] ?? ''); ?>"
        >
        <span class="form__error"><?= $errors['name'] ?></span>
    </div>
    <div class="form__item <?= isset($errors['message']) ? "form__item--invalid" : '' ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea
            id="message"
            name="message"
            placeholder="Напишите как с вами связаться"
        ><?= esc($form_data['message'] ?? '') ?></textarea>
        <span class="form__error"><?= $errors['message'] ?></span>
    </div>

    <?php if (!empty($errors)): ?>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <?php endif; ?>

    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="login.php">Уже есть аккаунт</a>
</form>
