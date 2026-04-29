<?php

declare(strict_types=1);

const FORMAT_THRESHOLD = 1000;

/**
 * @param string $value
 * @return string
 */
function esc(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}


/**
 * @param float $price
 * @return string
 */
function formatPrice(float $price): string {
    $price = ceil($price);
    return ($price > FORMAT_THRESHOLD
        ? number_format($price, 0, '', ' ')
        : $price) . ' ₽';
}

/**
 * @param string $value
 * @return array
 */
function remainingTime(string $value): array {
    $now = new DateTime();
    $future = new DateTime($value);

    $diff = date_diff($now, $future);

    $total_minutes = $diff->days * 24 * 60
                   + $diff->h * 60
                   + $diff->i;

    $hours = intdiv($total_minutes, 60);
    $minutes = $total_minutes % 60;

    return [$hours, $minutes];
}
