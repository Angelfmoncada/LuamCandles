ALTER TABLE orders ADD COLUMN IF NOT EXISTS transaction_id VARCHAR(100) AFTER payment_method;

CREATE TABLE IF NOT EXISTS paypal_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    transaction_id VARCHAR(100),
    event_type VARCHAR(50),
    response_json TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
