DELIMITER //

CREATE PROCEDURE stp_search_books(
    p_search TEXT
)
BEGIN

    SELECT 
        id, 
        title, 
        author, 
        description, 
        categories, 
        price, 
        user as userId
    FROM books
    WHERE IF (p_search = "", true, CONCAT(title, author, description, categories, price) LIKE CONCAT("%", REPLACE(p_search, " ", "%"), "%"))
    ORDER BY id DESC;

END //

DELIMITER ;
