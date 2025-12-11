CREATE DATABASE IF NOT EXISTS luamcandle;
USE luamcandle;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    category VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    shipping_address TEXT NOT NULL,
    payment_method VARCHAR(50),
    transaction_id VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE IF NOT EXISTS paypal_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    transaction_id VARCHAR(100),
    event_type VARCHAR(50),
    response_json TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_order_id (order_id),
    INDEX idx_transaction_id (transaction_id)
);

INSERT INTO users (name, email, password, role) VALUES
('Admin', 'admin@luam.com', '$2y$10$27jl8xYCHxWLI2/00ilaIuoDxggDgwuulbKTAe90hRrjjIbGUMloK', 'admin')
ON DUPLICATE KEY UPDATE email = email;

INSERT INTO products (name, description, price, image, category) VALUES
('Vela Lavanda Relax', 'Vela aromática con esencia de lavanda para momentos de relajación.', 15.00, 'Screenshot 2025-07-26 042148.png', 'Aromática'),
('Vela Vainilla Dulce', 'Dulce aroma a vainilla que calidez a tu hogar.', 18.50, 'Screenshot 2025-07-26 042218.png', 'Decorativa'),
('Vela Cítrica Energía', 'Energizante aroma a limón y naranja.', 16.00, 'Screenshot 2025-07-26 042236.png', 'Aromática'),
('Vela Bosque Místico', 'Notas de pino y madera.', 20.00, 'Screenshot 2025-07-26 042251.png', 'Aromática'),
('Set de Regalo', 'Pack de 3 velas pequeñas surtidas.', 45.00, 'Screenshot 2025-07-26 042344.png', 'Regalos'),
('Vela Rosa Romántica', 'Suave aroma a rosas frescas.', 19.00, 'Screenshot 2025-07-26 042356.png', 'Floral');
