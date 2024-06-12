DELIMITER / /

CREATE PROCEDURE stp_create_sale(
    p_user INT,
    p_book INT,
    p_quantity INT,
    p_price DECIMAL(10,2),
    p_available BOOLEAN
)
BEGIN
    DECLARE v_sale_id INT DEFAULT 0;
    DECLARE v_book_exists INT DEFAULT 0;

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


    SELECT COUNT(*) INTO v_book_exists FROM books WHERE id = p_book;

    IF v_book_exists = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'O livro especificado não existe!';
    ELSE

        INSERT INTO sales (book, quantity, price, available) 
        VALUES (p_book, p_quantity, p_price, p_available);


        SELECT LAST_INSERT_ID() INTO v_sale_id;


        CALL stp_add_to_cart(p_user, v_sale_id, p_quantity);
    END IF;

    COMMIT;
END //