<?php
require_once "models/BookBuilder.php";

class BookBuilderFactory
{
    public static function create(Book $book, int $userId, string $page = ""): CardBuilder
    {
        $bookBuilder = new BookNotOwnerCardBuilder();

        if ($userId == $book->getUserId() || $page == "create") {
            $bookBuilder = new BookOwnerCardBuilder();

            switch ($page) {
                case "view":
                    $bookBuilder->setIsView();
                    $bookBuilder->setIsReadonly(true);
                    break;

                case "update":
                    $bookBuilder->setIsUpdate();
                    $bookBuilder->setIsReadonly(false);
                    break;

                case "create":
                    $bookBuilder->setIsCreate();
                    $bookBuilder->setIsReadonly(false);
                    break;
            }
        }

        $bookBuilder->setBook($book);

        return $bookBuilder;
    }
}
