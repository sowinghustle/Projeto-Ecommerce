DELIMITER //

CREATE PROCEDURE stp_create_user(
    p_username VARCHAR(80),
    p_email VARCHAR(200),
    p_password TEXT,
    P_is_admin BOOLEAN
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;

    INSERT INTO users (username, email, password, is_admin)
    VALUES (replace(p_username, '"', ""), replace(p_email, '"', ""), p_password, p_is_admin);

    SELECT MAX(id) as id FROM users;

    COMMIT;
END //

DELIMITER ;
