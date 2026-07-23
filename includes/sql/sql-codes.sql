-- إنشاء الداتابيز
CREATE DATABASE IF NOT EXISTS shop_db;
USE shop_db;

-- جدول العملاء
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    salary DECIMAL(10,2) NOT NULL,
    city VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- جدول المنتجات
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

-- جدول الأوردرات
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    order_date DATE DEFAULT (CURRENT_DATE),
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- جدول الموظفين (مع self-join)
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    manager_id INT NULL,
    FOREIGN KEY (manager_id) REFERENCES employees(id)
);

-- بيانات تجريبية
INSERT INTO customers (name, salary, city, password) VALUES
('Ahmed Ali', 25000, 'Cairo', '$2y$10$e0NRZ1V8Y5Q8Y5Q8Y5Q8Yu5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5'),
('Tariq Hassan', 18000, 'Alex', '$2y$10$e0NRZ1V8Y5Q8Y5Q8Y5Q8Yu5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5'),
('Sara Mohamed', 35000, 'Cairo', '$2y$10$e0NRZ1V8Y5Q8Y5Q8Y5Q8Yu5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5'),
('Omar Khaled', 22000, 'Giza', '$2y$10$e0NRZ1V8Y5Q8Y5Q8Y5Q8Yu5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5'),
('Mona Samir', 45000, 'Alex', '$2y$10$e0NRZ1V8Y5Q8Y5Q8Y5Q8Yu5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5'),
('Youssef Adel', 15000, 'Cairo', '$2y$10$e0NRZ1V8Y5Q8Y5Q8Y5Q8Yu5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5');

INSERT INTO products (name, price) VALUES
('Milk', 12.50),
('Orange', 8.75),
('Bread', 15.00),
('Cheese', 45.00),
('Juice', 20.00),
('Rice', 30.00);

INSERT INTO orders (customer_id, product_id, quantity) VALUES
(1, 1, 5), (1, 2, 3), (1, 3, 2), (1, 4, 1), (1, 5, 4),
(2, 1, 2), (2, 3, 3), (2, 5, 1), (2, 6, 2), (2, 2, 4),
(3, 1, 10), (3, 2, 8), (3, 4, 5), (3, 6, 3),
(4, 2, 6), (4, 5, 2), (4, 1, 3),
(5, 4, 7), (5, 6, 5), (5, 1, 4), (5, 3, 2),
(6, 2, 3), (6, 5, 1);

INSERT INTO employees (name, manager_id) VALUES
('CEO Boss', NULL),
('Manager Ali', 1),
('Manager Sara', 1),
('Employee Omar', 2),
('Employee Mona', 2),
('Employee Youssef', 3),
('Employee Khaled', 3);