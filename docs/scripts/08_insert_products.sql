USE luamcandle;

INSERT INTO products (name, description, price, image, category) VALUES
('Vela Lavanda Relax', 'Vela aromática con esencia de lavanda para momentos de relajación.', 15.00, 'Screenshot 2025-07-26 042148.png', 'Aromática'),
('Vela Vainilla Dulce', 'Dulce aroma a vainilla que calidez a tu hogar.', 18.50, 'Screenshot 2025-07-26 042218.png', 'Decorativa'),
('Vela Cítrica Energía', 'Energizante aroma a limón y naranja.', 16.00, 'Screenshot 2025-07-26 042236.png', 'Aromática'),
('Vela Bosque Místico', 'Notas de pino y madera.', 20.00, 'Screenshot 2025-07-26 042251.png', 'Aromática'),
('Set de Regalo', 'Pack de 3 velas pequeñas surtidas.', 45.00, 'Screenshot 2025-07-26 042344.png', 'Regalos'),
('Vela Rosa Romántica', 'Suave aroma a rosas frescas.', 19.00, 'Screenshot 2025-07-26 042356.png', 'Floral')
ON DUPLICATE KEY UPDATE name = name;
