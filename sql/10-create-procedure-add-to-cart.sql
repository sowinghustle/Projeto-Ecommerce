DELIMITER //

CREATE PROCEDURE stp_add_to_cart(
    IN p_user INT,
    IN p_sale INT,
    IN p_quantity INT
)
BEGIN
    DECLARE v_cart_id INT DEFAULT 0;
    DECLARE v_available_quantity INT DEFAULT 0;
    DECLARE v_price DECIMAL(10,2) DEFAULT 0;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1 @sqlstate = RETURNED_SQLSTATE,
            @errno = MYSQL_ERRNO,
            @text = MESSAGE_TEXT;
        SELECT @sqlstate, @errno, @text;

        ROLLBACK;
    END;

    START TRANSACTION;


    SELECT id INTO v_cart_id 
    FROM carts 
    WHERE user = p_user AND finishedDate IS NULL
    LIMIT 1;

    IF v_cart_id IS NULL THEN
        INSERT INTO carts (user, finishedDate) 
        VALUES (p_user, NULL);
        SET v_cart_id = LAST_INSERT_ID();
    END IF;


    SELECT quantity, price INTO v_available_quantity, v_price 
    FROM sales
    WHERE id = p_sale;


    IF v_available_quantity < p_quantity THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'A quantidade de livros para comprar excede a disponibilidade!';
    ELSE

        INSERT INTO cartsales (cart, sale, quantity, price) 
        VALUES (v_cart_id, p_sale, p_quantity, v_price);
    END IF;

    COMMIT;
END //
