USE yeticave;

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;
SET collation_connection = utf8mb4_0900_ai_ci;

-- Adding data to the list categories
INSERT INTO `category` (name, slug) VALUES
  ('Доски и лыжи', 'boards'),
  ('Крепления', 'attachment'),
  ('Ботинки', 'boots'),
  ('Одежда', 'clothing'),
  ('Инструменты', 'tools'),
  ('Аксессуары', 'accessories'),
  ('Разное', 'other');
