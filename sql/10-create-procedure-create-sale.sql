DELIMITER //

CREATE PROCEDURE stp_create_sale(
    IN p_user INT,
    IN p_book INT,
    IN p_quantity INT,
    IN p_price DECIMAL(10,2),
    IN p_available BOOLEAN
)
BEGIN
    DECLARE v_sale_id INT DEFAULT 0;
    DECLARE v_book_exists INT DEFAULT 0;


    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN

        ROLLBACK;
        GET DIAGNOSTICS CONDITION 1 @sqlstate = RETURNED_SQLSTATE,
            @errno = MYSQL_ERRNO,
            @text = MESSAGE_TEXT;
        SELECT @sqlstate, @errno, @text;
    END;


    START TRANSACTION;


    SELECT COUNT(*) INTO v_book_exists FROM books WHERE id = p_book;

    IF v_book_exists = 0 THEN

        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'O livro especificado não existe!';
    ELSE
        INSERT INTO sales (book, quantity, price, available) 
        VALUES (p_book, p_quantity, p_price, p_available);

        SET v_sale_id = LAST_INSERT_ID();
    END IF;

    COMMIT;

    SELECT v_sale_id AS sale_id;
END //
