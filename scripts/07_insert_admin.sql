USE luamcandle;

INSERT INTO users (name, email, password, role) VALUES
('Admin', 'admin@luam.com', '$2y$10$27jl8xYCHxWLI2/00ilaIuoDxggDgwuulbKTAe90hRrjjIbGUMloK', 'admin')
ON DUPLICATE KEY UPDATE email = email;
