CREATE TABLE IF NOT EXISTS transacciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_id VARCHAR(100) NOT NULL,
    cliente_nombre VARCHAR(255),
    cliente_email VARCHAR(255),
    monto DECIMAL(10,2),
    estado VARCHAR(50),
    fecha_transaccion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    paypal_data JSON,
    INDEX idx_transaction_id (transaction_id),
    INDEX idx_cliente_email (cliente_email),
    INDEX idx_fecha (fecha_transaccion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
