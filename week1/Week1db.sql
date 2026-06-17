-- Database: `electronics`

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `products` (`id`, `name`, `brand`, `price`, `stock`) VALUES
(1, 'Wireless Bluetooth Headphones', 'Sony', 79.99, 15),
(2, 'USB-C Fast Charger 65W', 'Anker', 35.50, 25),
(3, 'Mechanical Keyboard RGB', 'Logitech', 89.99, 10);

ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;
