CREATE TABLE books (
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255),
    description TEXT,
    categories VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    user INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY(user) REFERENCES users(id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
