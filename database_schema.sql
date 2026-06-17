-- =====================================================
-- ElectroMart - Complete Database Schema
-- =====================================================

CREATE DATABASE IF NOT EXISTS electronics;
USE electronics;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    phone VARCHAR(20) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) DEFAULT NULL,
    brand VARCHAR(100) DEFAULT NULL,
    category VARCHAR(100) DEFAULT NULL,
    price DECIMAL(10,2) DEFAULT NULL,
    stock INT(11) DEFAULT NULL,
    rating DECIMAL(2,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    status VARCHAR(20) DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Order items table
CREATE TABLE IF NOT EXISTS order_items (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    order_id INT(11) NOT NULL,
    product_id INT(11) NOT NULL,
    quantity INT(11) NOT NULL DEFAULT 1,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Ratings table
CREATE TABLE IF NOT EXISTS ratings (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    product_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    rating DECIMAL(2,1) NOT NULL CHECK (rating >= 0.5 AND rating <= 5.0),
    review TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_rating (product_id, user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Password resets table
CREATE TABLE IF NOT EXISTS password_resets (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    token VARCHAR(100) NOT NULL,
    expires_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- Sample Data
-- =====================================================

-- Admin user (password: admin123)
INSERT INTO users (username, email, password, role, phone) VALUES
('admin', 'admin@electromart.com', '$2y$10$z2c7GAd7GqC3wv0OkxzM0erWanaTNdFaGKcTDa1j53Vj2ebOp1avm', 'admin', '1234567890'),
('john_doe', 'john@example.com', '$2y$10$z2c7GAd7GqC3wv0OkxzM0erWanaTNdFaGKcTDa1j53Vj2ebOp1avm', 'user', '9876543210');

-- Sample products
INSERT INTO products (id, name, brand, category, price, stock, rating) VALUES
(1, 'Wireless Bluetooth Headphones', 'Sony', 'Audio', 79.99, 15, 4.5),
(2, 'USB-C Fast Charger 65W', 'Anker', 'Accessories', 35.50, 25, 4.8),
(3, 'Mechanical Keyboard RGB', 'Logitech', 'Gaming', 89.99, 10, 4.2),
(4, '4K Ultra HD Monitor 27"', 'Dell', 'Monitors', 299.99, 8, 4.6),
(5, 'Noise Cancelling Earbuds', 'Bose', 'Audio', 149.99, 12, 4.7),
(6, 'Smartwatch Pro Max', 'Apple', 'Wearables', 399.99, 7, 4.4),
(7, 'Gaming Mouse Wireless', 'Razer', 'Gaming', 59.99, 20, 4.3),
(8, 'External SSD 1TB', 'Samsung', 'Storage', 89.99, 18, 4.9);

ALTER TABLE products MODIFY id INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
