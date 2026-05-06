<?php

declare(strict_types=1);

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
function getRemainingTime(string $value): array {
    $now = new DateTime();
    $future = new DateTime($value);

    $diff = date_diff($now, $future);

    $total_minutes = ($diff->days * HOURS_IN_DAY + $diff->h) * MINUTES_IN_HOUR + $diff->i;

    $hours = intdiv($total_minutes, MINUTES_IN_HOUR);
    $minutes = $total_minutes % MINUTES_IN_HOUR;

    return [$hours, $minutes];
}