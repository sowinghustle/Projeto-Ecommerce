CREATE TABLE carts (
    id INT NOT NULL AUTO_INCREMENT,
    user INT NOT NULL,
    finishedDate DATETIME,
    PRIMARY KEY (id),
    FOREIGN KEY (user) REFERENCES users (id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;