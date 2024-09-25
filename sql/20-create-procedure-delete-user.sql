DELIMITER //

CREATE PROCEDURE stp_delete_user(
    p_id INT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;
    
    DELETE FROM books WHERE user=p_id;
    DELETE FROM users WHERE id=p_id;

    COMMIT;
END //
