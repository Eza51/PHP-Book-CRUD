CREATE DATABASE book_manager;

USE book_manager;

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    publication_year INT(4) NOT NULL,
    genre VARCHAR(100)
);
