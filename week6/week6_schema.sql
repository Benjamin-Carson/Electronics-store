-- Week 6 Schema: Normalized tables with relationships for ElectroMart

DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS ratings;

CREATE TABLE orders (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    status VARCHAR(20) DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE order_items (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    order_id INT(11) NOT NULL,
    product_id INT(11) NOT NULL,
    quantity INT(11) NOT NULL DEFAULT 1,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE ratings (
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

INSERT INTO products (name, brand, category, price, stock, rating) VALUES
('Wireless Bluetooth Headphones', 'Sony', 'Audio', 79.99, 15, 4.5),
('USB-C Fast Charger 65W', 'Anker', 'Accessories', 35.50, 25, 4.8),
('Mechanical Keyboard RGB', 'Logitech', 'Gaming', 89.99, 10, 4.2),
('4K Ultra HD Monitor 27"', 'Dell', 'Monitors', 299.99, 8, 4.6),
('Noise Cancelling Earbuds', 'Bose', 'Audio', 149.99, 12, 4.7),
('Smartwatch Pro Max', 'Apple', 'Wearables', 399.99, 7, 4.4),
('Gaming Mouse Wireless', 'Razer', 'Gaming', 59.99, 20, 4.3),
('External SSD 1TB', 'Samsung', 'Storage', 89.99, 18, 4.9);
