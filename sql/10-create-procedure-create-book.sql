DELIMITER //

CREATE PROCEDURE stp_create_book(
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
        INSERT INTO books (
            title,
            author,
            description,
            categories,
            price,
            user
        )
        VALUES (
            replace(p_title, '"', ""),
            replace(p_author, '"', ""),
            replace(p_description, '"', "'"),
            replace(p_categories, '"', "'"),
            p_price,
            p_user
        );

        SELECT MAX(id) as id FROM books;
    COMMIT;
END //