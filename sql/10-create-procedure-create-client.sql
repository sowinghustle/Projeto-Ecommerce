DELIMITER //

CREATE PROCEDURE stp_create_client(
    p_username VARCHAR(80),
    p_email VARCHAR(200),
    p_password TEXT,
    OUT p_id INT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'An error occurred while creating the client';
    END;

    START TRANSACTION;

    INSERT INTO client (username, email, password)
    VALUES (p_username, p_email, p_password);

    SET p_id = LAST_INSERT_ID();

    COMMIT;
END //

DELIMITER ;
