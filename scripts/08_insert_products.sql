USE luamcandle;

INSERT INTO products (name, description, price, image, category) VALUES
('Vela de Lavanda Relajante', 'Vela aromática con esencia de lavanda para momentos de relajación.', 375.00, 'Screenshot 2025-07-26 042148.png', 'Aromática'),
('Vela de Vainilla Dulce', 'Dulce aroma a vainilla que brinda calidez a tu hogar.', 462.50, 'Screenshot 2025-07-26 042218.png', 'Decorativa'),
('Vela Cítrica Energizante', 'Energizante aroma a limón y naranja.', 400.00, 'Screenshot 2025-07-26 042236.png', 'Aromática'),
('Vela Bosque Místico', 'Notas de pino y madera.', 500.00, 'Screenshot 2025-07-26 042251.png', 'Aromática'),
('Set de Regalo', 'Pack de 3 velas pequeñas surtidas.', 1125.00, 'Screenshot 2025-07-26 042344.png', 'Regalos'),
('Vela Rosa Romántica', 'Suave aroma a rosas frescas.', 475.00, 'Screenshot 2025-07-26 042356.png', 'Floral')
ON DUPLICATE KEY UPDATE 
name = VALUES(name), 
description = VALUES(description), 
price = VALUES(price), 
category = VALUES(category);
