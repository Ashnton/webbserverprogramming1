CREATE DATABASE IF NOT EXISTS antonlm;
USE antonlm;

-- Tabell för vanliga användare
CREATE TABLE IF NOT EXISTS slutprojekt_hungry_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(320) NOT NULL,
    phonenumber INT(17) NOT NULL,
    password VARCHAR(255) NOT NULL,
    reg_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    latest_login DATETIME DEFAULT CURRENT_TIMESTAMP, 
    login_token VARCHAR(255)
);

-- Tabell för beställningar
CREATE TABLE IF NOT EXISTS slutprojekt_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    customer_id INT NOT NULL,
    restaurant_id INT NOT NULL,
    status VARCHAR(255), 
    price INT NOT NULL,
    token VARCHAR(255),
    FOREIGN KEY (item_id) REFERENCES slutprojekt_menu_items(id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES slutprojekt_hungry_users(id) ON DELETE CASCADE,
    FOREIGN KEY (restaurant_id) REFERENCES slutprojekt_restaurants(id) ON DELETE CASCADE
)

-- Tabell för restauranger
CREATE TABLE IF NOT EXISTS slutprojekt_restaurants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_name VARCHAR(255) NOT NULL,
    restaurant_enabled TINYINT(1) NOT NULL,
    logotype_url VARCHAR(255)
)

-- Tabell för restaurang användare
CREATE TABLE IF NOT EXISTS slutprojekt_restaurant_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT NOT NULL,
    email VARCHAR(320)
)