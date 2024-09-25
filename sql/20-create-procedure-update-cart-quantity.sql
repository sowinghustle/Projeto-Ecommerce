DELIMITER //

CREATE PROCEDURE stp_update_cart_quantity(
    IN p_cartsale INT,
    IN p_quantity INT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        GET DIAGNOSTICS CONDITION 1 @sqlstate = RETURNED_SQLSTATE,
            @errno = MYSQL_ERRNO,
            @text = MESSAGE_TEXT;
        SELECT @sqlstate, @errno, @text;
    END;

    START TRANSACTION;

    UPDATE cartsales
    SET quantity = p_quantity
    WHERE id = p_cartsale;

    COMMIT;
END //