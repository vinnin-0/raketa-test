CREATE TABLE IF NOT EXISTS products
(
    uuid CHAR(36) PRIMARY KEY NOT NULL COMMENT 'UUID товара',
    category VARCHAR(255) NOT NULL COMMENT 'Категория товара',
    is_active TINYINT DEFAULT 1 NOT NULL COMMENT 'Флаг активности',
    `name` TEXT NOT NULL DEFAULT '' COMMENT 'Тип услуги',
    `description` TEXT NULL COMMENT 'Описание товара',
    thumbnail VARCHAR(255) NULL COMMENT 'Ссылка на картинку',
    price DECIMAL(6,2) UNSIGNED NOT NULL COMMENT 'Цена'
)
    COMMENT 'Товары';

CREATE INDEX category_idx ON products (category);
