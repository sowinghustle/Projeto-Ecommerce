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
    END;

    START TRANSACTION;

    INSERT INTO clients (username, email, password)
    VALUES (p_username, p_email, p_password);

    SELECT MAX(id) INTO p_id FROM clients;

    COMMIT;
END //

DELIMITER ;
