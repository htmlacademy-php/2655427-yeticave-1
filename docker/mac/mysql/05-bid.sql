USE yeticave;

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;
SET collation_connection = utf8mb4_0900_ai_ci;

-- Adding bids for a lot 'DC Ply Mens 2016/2017 Snowboard'
INSERT INTO `bid` (amount, user_id, lot_id) VALUES
  (
    1100,
    4,
    2
  ),
  (
    550,
    2,
    2
  );
