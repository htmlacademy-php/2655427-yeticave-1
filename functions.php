<?php

declare(strict_types=1);

const FORMAT_THRESHOLD = 1000;

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