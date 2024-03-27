DELIMITER //

CREATE PROCEDURE stp_update_client(
    p_id INT,
    p_username VARCHAR(80),
    p_email VARCHAR(200),
    p_password TEXT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'An error occurred while updating the client';
    END;

    START TRANSACTION;

    UPDATE client SET 
        username=IFNULL(p_username, username),
        email=IFNULL(p_email, email),
        password=IFNULL(p_password, password)
    WHERE id=p_id;

    COMMIT;
END //

DELIMITER ;
