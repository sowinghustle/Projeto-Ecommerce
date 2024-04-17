DELIMITER //

CREATE PROCEDURE stp_update_book(
    p_id INT,
    p_title VARCHAR(255),
    p_author VARCHAR(255),
    p_description TEXT,
    p_categories VARCHAR(255),
    p_price DECIMAL(10, 2)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;

    UPDATE books SET
        title=replace(IFNULL(p_title, title), '"', ""),
        author=replace(IFNULL(p_author, author), '"', ""),
        description=replace(IFNULL(p_description, description), '"', "'"),
        categories=replace(IFNULL(p_categories, categories), '"', "'"),
        price=IFNULL(p_price, price)
    WHERE id=p_id;

    COMMIT;
END //

DELIMITER ;
