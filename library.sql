CREATE DATABASE library;
USE library;

CREATE TABLE book (
    ISBN VARCHAR(17) PRIMARY KEY NOT NULL, 
    title VARCHAR(255) NOT NULL, 
    publication_year INT,
    language VARCHAR(25) NOT NULL
);

CREATE TABLE author (
    name VARCHAR(50) NOT NULL,
    surname VARCHAR(25) NOT NULL, 
    birth_date DATE NOT NULL, 
    birth_place VARCHAR(255) NOT NULL,
    PRIMARY KEY (name, surname, birth_date, birth_place)
); 

CREATE TABLE department (
    name VARCHAR(50) PRIMARY KEY NOT NULL, 
    address VARCHAR(255) NOT NULL
);

CREATE TABLE user (
    serial_number VARCHAR(6) PRIMARY KEY, 
    name VARCHAR(50) NOT NULL,
    surname VARCHAR(25) NOT NULL, 
    telephone VARCHAR(13) NOT NULL, 
    address VARCHAR(255) NOT NULL
); 

CREATE TABLE copy (
    code INT AUTO_INCREMENT PRIMARY KEY, 
    ISBN VARCHAR(17) NOT NULL, 
    department_name VARCHAR(50) NOT NULL,
    FOREIGN KEY (ISBN) REFERENCES book(ISBN)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (department_name) REFERENCES department(name)
        ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE book_author (
    ISBN VARCHAR(17) NOT NULL, 
    author_name VARCHAR(50) NOT NULL,
    author_surname VARCHAR(25) NOT NULL, 
    author_birth_date DATE NOT NULL, 
    author_birth_place VARCHAR(255) NOT NULL,
    PRIMARY KEY (ISBN, author_name, author_surname, author_birth_date, author_birth_place),
    FOREIGN KEY (ISBN) REFERENCES book(ISBN)
        ON DELETE CASCADE ON UPDATE CASCADE, 
    FOREIGN KEY (author_name, author_surname, author_birth_date, author_birth_place)
        REFERENCES author(name, surname, birth_date, birth_place)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE loan (
    copy_code INT,
    serial_number VARCHAR(6), 
    exit_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (copy_code, serial_number),
    FOREIGN KEY (copy_code) REFERENCES copy(code)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (serial_number) REFERENCES user(serial_number)
        ON DELETE CASCADE ON UPDATE CASCADE
);
