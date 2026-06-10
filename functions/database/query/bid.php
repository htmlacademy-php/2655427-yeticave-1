<?php

declare(strict_types=1);

/**
 * Retrieves all bids for a specific lot
 *
 * @param mysqli $connection Active database connection
 * @param int    $lot_id
 *
 * @return array
 */
function getBidsByLotId(mysqli $connection, int $lot_id): array {
    if ($lot_id === 0) {
        return [];
    }

    $sql ="SELECT
        user.name AS user_name,
        bid.amount,
        bid.created_at,
        bid.user_id,
        lot.start_price,
        lot.bid_step
    FROM `bid`
    JOIN `user` ON  bid.user_id = user.id
    LEFT JOIN `lot`ON bid.lot_id = lot.id
    WHERE bid.lot_id = $lot_id
    ORDER BY bid.created_at DESC";

    return fetchAll($connection, $sql);
}

/**
 * Retrieves all bids placed by a specific user
 *
 * @param mysqli $connection Active database connection
 * @param int    $user_id    User ID whose bids should be retrieved
 *
 * @return ?array
 */
function getBidsByUserId(mysqli $connection, int $user_id): ?array {
    $sql ="SELECT
        bid.id,
        bid.user_id,
        bid.lot_id,
        bid.created_at,
        lot.expire_date,
        lot.img_url,
        lot.title,
        bid.amount,
        category.name AS category_name,
        user.contact_info
    FROM `bid`
    JOIN `lot`ON bid.lot_id = lot.id
    LEFT JOIN `category` ON category.id = lot.category_id
    LEFT JOIN `user` ON user.id = bid.user_id
    WHERE bid.user_id = $user_id
    ORDER BY bid.created_at DESC";

    return fetchAll($connection, $sql);
}

/**
 * Assigns winning bids for expired lots and returns winner bid IDs for a user
 *
 * @param mysqli $connection Active database connection
 * @param int    $user_id    User ID to fetch winner bids for
 *
 * @return array Array of winner bid IDs belonging to the user
 */
function getWinnerBid(mysqli $connection, int $user_id): array {
    $sql1 = "UPDATE lot l
    SET winner_bid_id = (
        SELECT b.id
        FROM bid b
        WHERE b.lot_id = l.id
        ORDER BY b.amount DESC, b.created_at ASC
        LIMIT 1)
     WHERE l.expire_date < NOW()";

    $connection->query($sql1);

    $sql2 = "SELECT
            lot.id AS lot_id,
            lot.winner_bid_id
        FROM lot
        LEFT JOIN bid ON bid.id = lot.winner_bid_id
        WHERE bid.user_id = $user_id";

    $rows = fetchAll($connection, $sql2);

    $result = [];

    foreach ($rows as $row) {
        $result[] = $row['winner_bid_id'];
    }
    return $result;
}

/**
 * Inserts a new bid into the database.
 *
 * @param mysqli $connection Active database connection
 * @param array  $data       Bid data for insertion
 *
 * @return int|string|null Returns inserted bid ID on success, null on failure
 */
function addBid(mysqli $connection, array $data): string|int|null {
    $sql = "INSERT INTO bid (
        amount,
        user_id,
        lot_id
    ) VALUES (?, ?, ?)";

    $stmt = db_get_prepare_stmt($connection, $sql, $data);
    if (mysqli_stmt_execute($stmt)) {
        return mysqli_insert_id($connection);
    }
    return null;
}
