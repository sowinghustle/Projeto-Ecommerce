CREATE TABLE cartsales (
    id INT NOT NULL AUTO_INCREMENT,
    sale INT NOT NULL,
    cart INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (sale) REFERENCES sales (id),
    FOREIGN KEY (cart) REFERENCES carts (id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;