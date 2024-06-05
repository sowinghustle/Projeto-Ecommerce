DELIMITER / /

CREATE PROCEDURE stp_add_to_cart(
    p_user INT,
    p_sale INT,
    p_quantity INT
)
BEGIN
    DECLARE v_cart_id INT DEFAULT 0;
    DECLARE v_quantity INT DEFAULT 0;
    DECLARE v_price DECIMAL(10,2) DEFAULT 0;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1 @sqlstate = returned_sqlstate,
            @errno = MYSQL_ERRNO,
            @text = MESSAGE_TEXT;
        SELECT @text;

        IF @text <> '' THEN
            ROLLBACK;
        END IF;
    END;

    START TRANSACTION;

    SELECT id INTO v_cart_id FROM carts WHERE user = p_user AND finishedDate is not NULL ;

    IF v_cart_id = 0 THEN
        INSERT INTO carts (user, finishedDate) VALUES (p_user, NULL);
        SELECT MAX(id) INTO v_cart_id FROM carts WHERE user = p_user ;
    END IF;

    SELECT quantity, price INTO v_quantity, v_price FROM sales
    WHERE id = p_sale;

    IF v_quantity < p_quantity THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'A quantidade de livros para comprar excede a disponibilidade!';
    END IF;
    
    INSERT INTO cartsales (cart, sale, quantity, price) 
    VALUES (v_cart_id, p_sale, v_quantity, v_price);

    COMMIT;
END //