CREATE DATABASE IF NOT EXISTS quizdb;
USE quizdb;

--
-- Tabell för kunder (både "vanliga" kunder och admins).
--
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    namn VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    senaste_inloggning DATETIME DEFAULT NULL,
    is_admin TINYINT(1) NOT NULL DEFAULT 0  -- 0 = kund, 1 = admin
);

--
-- Tabell för test-information
--
CREATE TABLE IF NOT EXISTS tests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    test_name VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

--
-- Tabell för frågor
--
CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    test_id INT NOT NULL,
    question_text VARCHAR(255) NOT NULL,
    FOREIGN KEY (test_id) REFERENCES tests(id)
      ON DELETE CASCADE
);

--
-- Tabell för svarsalternativ
--
CREATE TABLE IF NOT EXISTS answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT NOT NULL,
    answer_text VARCHAR(255) NOT NULL,
    is_correct TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (question_id) REFERENCES questions(id)
      ON DELETE CASCADE
);

--
-- Tabell för sparade resultat (poäng per test)
--
CREATE TABLE IF NOT EXISTS results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    test_id INT NOT NULL,
    score INT NOT NULL,
    taken_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
      ON DELETE CASCADE,
    FOREIGN KEY (test_id) REFERENCES tests(id)
      ON DELETE CASCADE
);

--
-- Tabell för användarens svar (för att kunna visa grönt/rött i efterhand)
--
CREATE TABLE IF NOT EXISTS user_answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    result_id INT NOT NULL,
    question_id INT NOT NULL,
    answer_id INT NOT NULL,
    is_correct TINYINT(1) NOT NULL,
    FOREIGN KEY (result_id) REFERENCES results(id)
      ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES questions(id)
      ON DELETE CASCADE,
    FOREIGN KEY (answer_id) REFERENCES answers(id)
      ON DELETE CASCADE
);
