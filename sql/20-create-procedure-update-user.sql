DELIMITER //

CREATE PROCEDURE stp_update_user(
    p_id INT,
    p_username VARCHAR(80),
    p_email VARCHAR(200),
    p_password TEXT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;

    UPDATE users SET 
        username=IFNULL(p_username, username),
        email=IFNULL(p_email, email),
        password=IFNULL(p_password, password)
    WHERE id=p_id;

    COMMIT;
END //

DELIMITER ;
