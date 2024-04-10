DELIMITER //

CREATE PROCEDURE stp_update_book(
    p_id INT,
    p_title VARCHAR(255),
    p_author VARCHAR(255),
    p_description TEXT,
    p_categories VARCHAR(255),
    p_price DECIMAL(10, 2),
    p_user INT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;

    UPDATE books SET
        title=IFNULL(p_title, title),
        author=IFNULL(p_author, author),
        description=IFNULL(p_description, description),
        categories=IFNULL(p_categories, categories),
        price=IFNULL(p_price, price)
    WHERE id=p_id;

    COMMIT;
END //

DELIMITER ;
