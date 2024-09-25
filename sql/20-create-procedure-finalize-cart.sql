DELIMITER //

CREATE PROCEDURE stp_finalize_cart(
    IN p_cart INT
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

    UPDATE carts
    SET finishedDate = NOW()
    WHERE id = p_cart;

    COMMIT;
END //
