-- Get all categories
SELECT
    id,
    name,
    slug
FROM `category`;

-- Get the newest open lots
SELECT
    lot.id,
    lot.title,
    lot.start_price,
    lot.img_url,
    COALESCE(MAX(bid.amount), lot.start_price) AS current_price,
    category.name AS category_name
FROM `lot`
LEFT JOIN `bid` ON bid.lot_id = lot.id
JOIN `category` ON lot.category_id = category.id
WHERE lot.expire_date >  NOW()
GROUP BY lot.id
ORDER BY lot.created_at DESC;

-- Get the lot by id
SELECT
    lot.id,
    lot.title,
    lot.start_price,
    lot.img_url,
    COALESCE(MAX(bid.amount), lot.start_price) AS current_price,
    category.name AS category_name
FROM `lot`
LEFT JOIN `bid` ON bid.lot_id = lot.id
JOIN `category` ON lot.category_id = category.id
WHERE lot.id = 2
GROUP BY lot.id;

-- Update the lot name by its ID
UPDATE `lot`
SET title = 'Горнолыжная Маска Oakley Canopy'
WHERE id = 6;

-- Get a list of bids by lot ID
SELECT
    bid.lot_id,
    bid.user_id,
    lot.title,
    bid.amount,
    bid.created_at
FROM `bid`
JOIN `lot` ON bid.lot_id = lot.id
WHERE bid.lot_id = 2
ORDER BY bid.created_at DESC;
