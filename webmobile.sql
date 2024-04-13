-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 02, 2024 lúc 20:45 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12
-- Tên cơ sở dữ liệu: webmobile

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `tbl_users` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  `name` varchar(55),
  `username` varchar(55),
  `password` varchar(55),
  `email` varchar(55),
  `phone_number` varchar(55),
  `gender` varchar(20),
  `address` varchar(255),
  `status` int
);

CREATE TABLE `tbl_roles` (
  `id` int(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20)
);

CREATE TABLE `tbl_reviews` (
  `id` int(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `comment` text,
  `stars` int,
  `status` int,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `tbl_categories` (
  `id` int(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(55)
);

CREATE TABLE `tbl_products` (
  `id` int(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `name` varchar(55),
  `url` varchar(55),
  `image` varchar(55),
  `description` varchar(55),
  `price` varchar(55),
  `color` varchar(55),
  `percent_discount` int,
  `ram` varchar(55),
  `internal_memory` varchar(55),
  `battery` varchar(55),
  `chipset` varchar(55),
  `screen_size` varchar(55),
  `screen_technology` varchar(55)
);

CREATE TABLE `tbl_orders` (
  `id` int(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `status` varchar(20),
  `total_amount` int,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `tbl_order_items` (
  `id` int(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `price` int,
  `quantity` int
);

CREATE TABLE `tbl_cart` (
  `id` int(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `price` int,
  `quantity` int
);

-- Insert sample roles
INSERT INTO tbl_roles (id, role_name) VALUES (1, 'Admin'), (2, 'Customer');

-- Insert sample users
INSERT INTO tbl_users (id, role_id, name, username, password, email, phone_number, gender, address, status) 
VALUES 
(1, 1, 'Admin User', 'admin', 'admin123', 'admin@example.com', '123456789', 'Male', '123 Admin St', 1),
(2, 2, 'John Doe', 'john_doe', 'john123', 'john@example.com', '987654321', 'Male', '456 Main St', 1),
(3, 2, 'Jane Smith', 'jane_smith', 'jane123', 'jane@example.com', '555555555', 'Female', '789 Elm St', 1),
(4, 2, 'Michael Johnson', 'michael_johnson', 'michael123', 'michael@example.com', '111111111', 'Male', '101 Oak St', 1),
(5, 2, 'Emily Brown', 'emily_brown', 'emily123', 'emily@example.com', '222222222', 'Female', '246 Pine St', 1);

-- Insert sample categories for smartphone brands
INSERT INTO tbl_categories (id, name) 
VALUES 
(1, 'Realme'), 
(2, 'Apple'), 
(3, 'Redmi'),
(4, 'Samsung'),
(5, 'OnePlus');

-- Insert 10 more sample products for the "Realme" category with realistic prices
INSERT INTO tbl_products (id, category_id, url, image, name, description, price, color, percent_discount, ram, internal_memory, battery, chipset, screen_size, screen_technology) 
VALUES 
(1, 1, 'realme-narzo-30a', 'realme-narzo-30a.jpg', 'Realme Narzo 30A', 'Realme Narzo 30A', '3290000', 'Blue', 0, '4GB', '64GB', '6000mAh', 'MediaTek Helio G85', '6.5 inches', 'IPS LCD'),
(2, 1, 'realme-8', 'realme-8.jpg', 'Realme 8', 'Realme 8', '5590000', 'Black', 0, '8GB', '128GB', '5000mAh', 'MediaTek Helio G95', '6.4 inches', 'Super AMOLED'),
(3, 1, 'realme-c25', 'realme-c25.jpg', 'Realme C25', 'Realme C25', '3990000', 'Gray', 0, '4GB', '64GB', '6000mAh', 'MediaTek Helio G70', '6.5 inches', 'IPS LCD'),
(4, 1, 'realme-gt-2-pro', 'realme-gt-2-pro.jpg', 'Realme GT 2 Pro', 'Realme GT 2 Pro', '19990000', 'Black', 0, '12GB', '256GB', '5000mAh', 'Snapdragon 8 Gen 1', '6.7 inches', 'Super AMOLED'),
(5, 1, 'realme-c21', 'realme-c21.jpg', 'Realme C21', 'Realme C21', '2990000', 'Blue', 0, '3GB', '32GB', '5000mAh', 'MediaTek Helio G35', '6.5 inches', 'IPS LCD'),
(6, 1, 'realme-7', 'realme-7.jpg', 'Realme 7', 'Realme 7', '4990000', 'Mist White', 0, '8GB', '128GB', '5000mAh', 'Helio G95', '6.5 inches', 'IPS LCD'),
(7, 1, 'realme-narzo-50a', 'realme-narzo-50a.jpg', 'Realme Narzo 50A', 'Realme Narzo 50A', '4190000', 'Oxygen Green', 0, '4GB', '128GB', '6000mAh', 'MediaTek Helio G85', '6.5 inches', 'IPS LCD'),
(8, 1, 'realme-c11', 'realme-c11.jpg', 'Realme C11', 'Realme C11', '2390000', 'Pepper Grey', 0, '2GB', '32GB', '5000mAh', 'MediaTek Helio G35', '6.5 inches', 'IPS LCD'),
(9, 1, 'realme-9i', 'realme-9i.jpg', 'Realme 9i', 'Realme 9i', '3990000', 'Space Purple', 0, '4GB', '64GB', '6000mAh', 'MediaTek Helio G96', '6.6 inches', 'IPS LCD'),
(10, 1, 'realme-5-pro', 'realme-5-pro.jpg', 'Realme 5 Pro', 'Realme 5 Pro', '5690000', 'Crystal Green', 0, '8GB', '128GB', '4035mAh', 'Snapdragon 712', '6.3 inches', 'IPS LCD'),
(11, 2, 'iphone-12-mini', 'iphone-12-mini.jpg', 'iPhone 12 Mini', 'iPhone 12 Mini', '16990000', 'Black', 0, '4GB', '64GB', '2227mAh', 'A14 Bionic', '5.4 inches', 'Super Retina XDR'),
(12, 2, 'iphone-13-pro', 'iphone-13-pro.jpg', 'iPhone 13 Pro', 'iPhone 13 Pro', '37990000', 'Graphite', 0, '6GB', '128GB', '3095mAh', 'A15 Bionic', '6.1 inches', 'Super Retina XDR'),
(13, 2, 'iphone-11', 'iphone-11.jpg', 'iPhone 11', 'iPhone 11', '20990000', 'Purple', 0, '4GB', '64GB', '3110mAh', 'A13 Bionic', '6.1 inches', 'Liquid Retina HD'),
(14, 2, 'iphone-13-pro-max', 'iphone-13-pro-max.jpg', 'iPhone 13 Pro Max', 'iPhone 13 Pro Max', '40990000', 'Gold', 0, '6GB', '256GB', '4352mAh', 'A15 Bionic', '6.7 inches', 'Super Retina XDR'),
(15, 2, 'iphone-xr', 'iphone-xr.jpg', 'iPhone XR', 'iPhone XR', '17490000', 'Coral', 0, '3GB', '64GB', '2942mAh', 'A12 Bionic', '6.1 inches', 'Liquid Retina HD'),
(16, 2, 'iphone-12', 'iphone-12.jpg', 'iPhone 12', 'iPhone 12', '22990000', 'White', 0, '4GB', '64GB', '2815mAh', 'A14 Bionic', '6.1 inches', 'Super Retina XDR'),
(17, 2, 'iphone-se', 'iphone-se.jpg', 'iPhone SE', 'iPhone SE', '10490000', 'Product Red', 0, '3GB', '64GB', '1821mAh', 'A13 Bionic', '4.7 inches', 'Retina HD'),
(18, 2, 'iphone-13-mini', 'iphone-13-mini.jpg', 'iPhone 13 Mini', 'iPhone 13 Mini', '26990000', 'Blue', 0, '4GB', '128GB', '2406mAh', 'A15 Bionic', '5.4 inches', 'Super Retina XDR'),
(19, 2, 'iphone-12-pro', 'iphone-12-pro.jpg', 'iPhone 12 Pro', 'iPhone 12 Pro', '31990000', 'Pacific Blue', 0, '6GB', '128GB', '2815mAh', 'A14 Bionic', '6.1 inches', 'Super Retina XDR'),
(20, 2, 'iphone-12-pro-max', 'iphone-12-pro-max.jpg', 'iPhone 12 Pro Max', 'iPhone 12 Pro Max', '37990000', 'Silver', 0, '6GB', '128GB', '3687mAh', 'A14 Bionic', '6.7 inches', 'Super Retina XDR'),
(21, 3, 'redmi-note-10', 'redmi-note-10.jpg', 'Redmi Note 10', 'Redmi Note 10', '5990000', 'Frost White', 0, '4GB', '64GB', '5000mAh', 'Snapdragon 678', '6.43 inches', 'Super AMOLED'),
(22, 3, 'redmi-note-11', 'redmi-note-11.jpg', 'Redmi Note 11', 'Redmi Note 11', '4490000', 'Graphite Gray', 0, '6GB', '128GB', '5000mAh', 'Snapdragon 680', '6.43 inches', 'IPS LCD'),
(23, 3, 'redmi-10', 'redmi-10.jpg', 'Redmi 10', 'Redmi 10', '3990000', 'Carbon Gray', 0, '4GB', '64GB', '5000mAh', 'MediaTek Helio G88', '6.5 inches', 'IPS LCD'),
(24, 3, 'redmi-9c', 'redmi-9c.jpg', 'Redmi 9C', 'Redmi 9C', '2490000', 'Twilight Blue', 0, '3GB', '64GB', '5000mAh', 'MediaTek Helio G35', '6.53 inches', 'IPS LCD'),
(25, 3, 'redmi-k40', 'redmi-k40.jpg', 'Redmi K40', 'Redmi K40', '9990000', 'Dreamland', 0, '8GB', '128GB', '4520mAh', 'Snapdragon 870', '6.67 inches', 'Super AMOLED'),
(26, 3, 'redmi-note-10-pro', 'redmi-note-10-pro.jpg', 'Redmi Note 10 Pro', 'Redmi Note 10 Pro', '7990000', 'Glacial Blue', 0, '6GB', '128GB', '5020mAh', 'Snapdragon 732G', '6.67 inches', 'Super AMOLED'),
(27, 3, 'redmi-9a', 'redmi-9a.jpg', 'Redmi 9A', 'Redmi 9A', '1990000', 'Sea Blue', 0, '2GB', '32GB', '5000mAh', 'MediaTek Helio G25', '6.53 inches', 'IPS LCD'),
(28, 3, 'redmi-k40-pro', 'redmi-k40-pro.jpg', 'Redmi K40 Pro', 'Redmi K40 Pro', '13990000', 'Starry Sky', 0, '8GB', '128GB', '4520mAh', 'Snapdragon 888', '6.67 inches', 'Super AMOLED'),
(29, 3, 'redmi-10a', 'redmi-10a.jpg', 'Redmi 10A', 'Redmi 10A', '2290000', 'Pebble White', 0, '2GB', '32GB', '5000mAh', 'MediaTek Helio G25', '6.53 inches', 'IPS LCD'),
(30, 3, 'redmi-note-11-pro', 'redmi-note-11-pro.jpg', 'Redmi Note 11 Pro', 'Redmi Note 11 Pro', '8490000', 'Star Blue', 0, '8GB', '128GB', '5000mAh', 'Snapdragon 695', '6.67 inches', 'Super AMOLED'),
(31, 4, 'samsung-galaxy-a52', 'samsung-galaxy-a52.jpg', 'Samsung Galaxy A52', 'Samsung Galaxy A52', '9990000', 'Awesome Blue', 0, '6GB', '128GB', '4500mAh', 'Snapdragon 720G', '6.5 inches', 'Super AMOLED'),
(32, 4, 'samsung-galaxy-a32', 'samsung-galaxy-a32.jpg', 'Samsung Galaxy A32', 'Samsung Galaxy A32', '6490000', 'Awesome Black', 0, '6GB', '128GB', '5000mAh', 'MediaTek Helio G80', '6.4 inches', 'Super AMOLED'),
(33, 4, 'samsung-galaxy-m32', 'samsung-galaxy-m32.jpg', 'Samsung Galaxy M32', 'Samsung Galaxy M32', '5290000', 'Light Blue', 0, '6GB', '128GB', '6000mAh', 'MediaTek Helio G80', '6.4 inches', 'Super AMOLED'),
(34, 4, 'samsung-galaxy-a72', 'samsung-galaxy-a72.jpg', 'Samsung Galaxy A72', 'Samsung Galaxy A72', '12990000', 'Awesome Violet', 0, '8GB', '256GB', '5000mAh', 'Snapdragon 720G', '6.7 inches', 'Super AMOLED'),
(35, 4, 'samsung-galaxy-m22', 'samsung-galaxy-m22.jpg', 'Samsung Galaxy M22', 'Samsung Galaxy M22', '3490000', 'Mint', 0, '4GB', '64GB', '5000mAh', 'MediaTek Helio G80', '6.4 inches', 'Super AMOLED'),
(36, 4, 'samsung-galaxy-f41', 'samsung-galaxy-f41.jpg', 'Samsung Galaxy F41', 'Samsung Galaxy F41', '6990000', 'Fusion Black', 0, '6GB', '128GB', '6000mAh', 'Exynos 9611', '6.4 inches', 'Super AMOLED'),
(37, 4, 'samsung-galaxy-m12', 'samsung-galaxy-m12.jpg', 'Samsung Galaxy M12', 'Samsung Galaxy M12', '4990000', 'Attractive Black', 0, '4GB', '64GB', '6000mAh', 'Exynos 850', '6.5 inches', 'PLS IPS'),
(38, 4, 'samsung-galaxy-a12', 'samsung-galaxy-a12.jpg', 'Samsung Galaxy A12', 'Samsung Galaxy A12', '3990000', 'Black', 0, '4GB', '64GB', '5000mAh', 'MediaTek Helio P35', '6.5 inches', 'PLS IPS'),
(39, 4, 'samsung-galaxy-m02s', 'samsung-galaxy-m02s.jpg', 'Samsung Galaxy M02s', 'Samsung Galaxy M02s', '2490000', 'Red', 0, '3GB', '32GB', '5000mAh', 'Snapdragon 450', '6.5 inches', 'PLS IPS'),
(40, 4, 'samsung-galaxy-m52', 'samsung-galaxy-m52.jpg', 'Samsung Galaxy M52', 'Samsung Galaxy M52', '10990000', 'Sky Blue', 0, '8GB', '256GB', '5000mAh', 'Snapdragon 778G', '6.7 inches', 'Super AMOLED'),
(41, 5, 'oneplus-9-pro', 'oneplus-9-pro.jpg', 'OnePlus 9 Pro', 'OnePlus 9 Pro', '29990000', 'Morning Mist', 0, '12GB', '256GB', '4500mAh', 'Snapdragon 888', '6.7 inches', 'Fluid AMOLED'),
(42, 5, 'oneplus-9', 'oneplus-9.jpg', 'OnePlus 9', 'OnePlus 9', '24990000', 'Astral Black', 0, '8GB', '128GB', '4500mAh', 'Snapdragon 888', '6.55 inches', 'Fluid AMOLED'),
(43, 5, 'oneplus-nord-2', 'oneplus-nord-2.jpg', 'OnePlus Nord 2', 'OnePlus Nord 2', '19990000', 'Gray Sierra', 0, '12GB', '256GB', '4500mAh', 'MediaTek Dimensity 1200', '6.43 inches', 'Fluid AMOLED'),
(44, 5, 'oneplus-nord-ce', 'oneplus-nord-ce.jpg', 'OnePlus Nord CE', 'OnePlus Nord CE', '13990000', 'Charcoal Ink', 0, '8GB', '128GB', '4500mAh', 'Snapdragon 750G', '6.43 inches', 'Fluid AMOLED'),
(45, 5, 'oneplus-8t', 'oneplus-8t.jpg', 'OnePlus 8T', 'OnePlus 8T', '19990000', 'Lunar Silver', 0, '12GB', '256GB', '4500mAh', 'Snapdragon 865', '6.55 inches', 'Fluid AMOLED'),
(46, 5, 'oneplus-8-pro', 'oneplus-8-pro.jpg', 'OnePlus 8 Pro', 'OnePlus 8 Pro', '26990000', 'Glacial Green', 0, '12GB', '256GB', '4510mAh', 'Snapdragon 865', '6.78 inches', 'Fluid AMOLED'),
(47, 5, 'oneplus-8', 'oneplus-8.jpg', 'OnePlus 8', 'OnePlus 8', '22990000', 'Glacial Green', 0, '12GB', '256GB', '4300mAh', 'Snapdragon 865', '6.55 inches', 'Fluid AMOLED'),
(48, 5, 'oneplus-7t-pro', 'oneplus-7t-pro.jpg', 'OnePlus 7T Pro', 'OnePlus 7T Pro', '26990000', 'Haze Blue', 0, '8GB', '256GB', '4085mAh', 'Snapdragon 855+', '6.67 inches', 'Fluid AMOLED'),
(49, 5, 'oneplus-7t', 'oneplus-7t.jpg', 'OnePlus 7T', 'OnePlus 7T', '14990000', 'Glacier Blue', 0, '8GB', '256GB', '3800mAh', 'Snapdragon 855+', '6.55 inches', 'Fluid AMOLED'),
(50, 5, 'oneplus-nord', 'oneplus-nord.jpg', 'OnePlus Nord', 'OnePlus Nord', '13990000', 'Blue Marble', 0, '12GB', '256GB', '4115mAh', 'Snapdragon 765G', '6.44 inches', 'Fluid AMOLED');

-- Insert sample orders
INSERT INTO tbl_orders (id, user_id, status, total_amount, created_at, updated_at)
VALUES 
(1, 1, 'đã xử lý', null,  NOW(), NOW() - INTERVAL 1 DAY), -- Processed
(2, 2, 'chưa xử lý', null, NOW() - INTERVAL 2 DAY, NOW()), -- Pending
(3, 3, 'đã huỷ', null, NOW() - INTERVAL 3 DAY, NOW() - INTERVAL 1 DAY); -- Canceled

-- Insert sample order details
INSERT INTO tbl_order_items (id, order_id, product_id, price, quantity) 
VALUES 
(1, 1, 1, 3290000, 2),
(2, 1, 2, 5590000, 1),
(3, 2, 3, 3990000, 3),
(4, 2, 4, 19990000, 1),
(5, 3, 5, 2990000, 1),
(6, 3, 6, 4990000, 2),
(7, 3, 7, 4190000, 1);

-- Insert more sample reviews
INSERT INTO tbl_reviews (id, user_id, product_id, comment, stars, status, created_at, updated_at) 
VALUES 
(1, 3, 3, 'Good value for money', 4, 1, NOW(), NOW()),
(2, 4, 4, 'Excellent performance', 5, 1, NOW(), NOW()),
(3, 5, 5, 'Nice design', 4, 1, NOW(), NOW()),
(4, 3, 6, 'Impressive features', 5, 1, NOW(), NOW()),
(5, 4, 7, 'Battery life is great', 4, 1, NOW(), NOW()),
(6, 5, 8, 'Decent budget phone', 3, 1, NOW(), NOW()),
(7, 3, 9, 'Fast delivery', 5, 1, NOW(), NOW()),
(8, 4, 10, 'Satisfied with the purchase', 4, 1, NOW(), NOW()),
(9, 5, 11, 'Love the color', 5, 1, NOW(), NOW()),
(10, 3, 12, 'Smooth performance', 4, 1, NOW(), NOW());

-- Insert more sample cart items
INSERT INTO tbl_cart (id, user_id, product_id, price, quantity) 
VALUES 
(1, 2, 1, 3290000, 2),
(2, 3, 2, 5590000, 1),
(3, 4, 3, 3990000, 3),
(4, 5, 4, 19990000, 1),
(5, 2, 5, 2990000, 1),
(6, 3, 6, 4990000, 2),
(7, 4, 7, 4190000, 1);


ALTER TABLE `tbl_users` ADD FOREIGN KEY (`role_id`) REFERENCES `tbl_roles` (`id`);

ALTER TABLE `tbl_reviews` ADD FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`);

ALTER TABLE `tbl_reviews` ADD FOREIGN KEY (`product_id`) REFERENCES `tbl_products` (`id`);

ALTER TABLE `tbl_products` ADD FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`id`);

ALTER TABLE `tbl_orders` ADD FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`);

ALTER TABLE `tbl_order_items` ADD FOREIGN KEY (`order_id`) REFERENCES `tbl_orders` (`id`);

ALTER TABLE `tbl_order_items` ADD FOREIGN KEY (`product_id`) REFERENCES `tbl_products` (`id`);

ALTER TABLE `tbl_cart` ADD FOREIGN KEY (`product_id`) REFERENCES `tbl_products` (`id`);

ALTER TABLE `tbl_cart` ADD FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`);