<?php

declare(strict_types=1);

/**
 * Returns the validation rules for the lot addition form
 *
 * @param array $category_id List of valid categories for category validation
 *
 * @return array
 */
function getAddLotRules(array $category_id): array {
    return [
        'category' => fn($value) => validateCategory((int)$value, $category_id),
        'lot-rate' => 'validatePositiveInt',
        'lot-step' => 'validatePositiveInt',
        'lot-date' => 'validateDate'
    ];
}
