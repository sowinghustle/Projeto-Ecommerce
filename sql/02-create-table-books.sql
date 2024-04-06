CREATE TABLE books (
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255),
    description TEXT,
    isbn VARCHAR(255) UNIQUE NOT NULL,
    categories VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (id)
);
