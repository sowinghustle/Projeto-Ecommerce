CREATE TABLE sales (
    id INT NOT NULL AUTO_INCREMENT,
    book INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    available BOOLEAN NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (book) REFERENCES books (id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;